<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User_voucher;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart as CartModel; // Đổi tên alias tránh trùng với thư viện Cart
use App\Models\Order_item;
use App\Models\Variant;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ClientOrderController extends Controller
{
    // Trang thanh toán
    public function checkout()
    {
        $userId = Auth::id();

        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = Cart::with(['variant.product', 'variant.color', 'variant.size'])
            ->where('id_user', $userId)
            ->get();

        // Tính tổng tiền trước giảm giá
        $cartTotalBeforeDiscount = $cartItems->sum(fn($item) => $item->quantity * $item->price + 30000); // 30000 là phí vận chuyển cố định

        // Giả lập giảm giá nếu có mã giảm giá
        $cartDiscount = session('cart_discount', 0);

        // Tổng tiền sau giảm giá
        $cartTotalAfterDiscount = max(0, $cartTotalBeforeDiscount - $cartDiscount);

        return view('home.checkout', compact('cartItems', 'cartTotalBeforeDiscount', 'cartDiscount', 'cartTotalAfterDiscount'));
    }
    //Xử lý voucher
    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->voucher_code;
        $voucher = Voucher::where('code', $voucherCode)->where('status', 'active')->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher không hợp lệ hoặc đã hết hạn.'
            ]);
        }

        $cartTotal = $this->calculateCartTotal();

        if ($voucher->min_order_value && $cartTotal < $voucher->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng chưa đạt mức tối thiểu để áp dụng voucher.'
            ]);
        }

        $discountAmount = 0;
        if ($voucher->discount_type === 'percentage') {
            $discountAmount = ($cartTotal * $voucher->discount_value) / 100;
            if ($voucher->max_discount) {
                $discountAmount = min($discountAmount, $voucher->max_discount);
            }
        } else {
            $discountAmount = $voucher->discount_value;
        }

        $cartTotalAfterDiscount = max(0, $cartTotal - $discountAmount);

        // Lưu giảm giá vào session để sử dụng khi đặt hàng
        session([
            'id_voucher' => $voucher->id,
            'voucher_code' => $voucherCode,
            'discount_amount' => $discountAmount,
            'cart_total_after_discount' => $cartTotalAfterDiscount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công!',
            'discount' => $discountAmount,
            'cart_total_after_discount' => $cartTotalAfterDiscount
        ]);
    }

    // Xử lý đặt hàng

public function placeOrder(Request $request)
{
    $validated = $request->validate([
        'fullname' => 'required',
        'phone' => 'required',
        'shipping_address' => 'required',
        'payment_method' => 'required',
        'voucher_code' => 'nullable|string',
    ]);
    $user = Auth::user();
    // Lấy danh sách sản phẩm trong giỏ hàng
    $cartItems = Cart::with(['variant.product', 'variant.color', 'variant.size'])
        ->where('id_user', $user->id)
        ->get();
    // Kiểm tra số lượng sản phẩm có đủ không
    foreach ($cartItems as $item) {
        $variant = Variant::find($item['id_variant']);
        if (!$variant || $variant->quantity < $item['quantity']) {
            return response()->json([
                'error' => "Sản phẩm {$variant->product->name} {$variant->product->id} (Size: {$variant->size}, Color: {$variant->color}) không đủ hàng."
            ], 400);
        }
    }

         // Kiểm tra voucher nếu có
            $voucherId = session('id_voucher') ?? null; // Lấy voucher từ session
            $discountAmount = 0; // Mặc định không có giảm giá
            $voucher = null;

            if ($voucherId) { // Chỉ kiểm tra nếu có voucher
                $voucher = Voucher::find($voucherId);
                if ($voucher && $voucher->quantity > 0) {
                    $discountAmount = session('discount_amount', 0); // Lấy giá trị giảm giá từ session
                    $voucher->quantity -= 1;
                    $voucher->save();

                    User_voucher::create([
                        'id_user' => $user->id,
                        'id_voucher' => $voucher->id,
                    ]);
                }
            }

    // Tính tổng tiền của các sản phẩm trong giỏ hàng
    $cartTotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    $shippingFee = 30000; // Phí vận chuyển

    // Nếu không có voucher, total_price = tổng tiền sản phẩm + phí ship
    // Tính toán giảm giá
    $discountAmount = session('discount_amount');
    $totalAfterDiscount = session('cart_total_after_discount');

    // Tạo đơn hàng
    $order = Order::create([
        'fullname' => $request->fullname,
        'phone' => $request->phone,
        'shipping_address' => $request->shipping_address,
        'id_user' => Auth::id(),
        'total_price' => $voucher ? $totalAfterDiscount : $cartTotal + $shippingFee, // Nếu không có voucher thì cộng phí ship
        'id_voucher' => $voucher ? $voucher->id : null,
        'discount_amount' => $voucher ? $discountAmount : 0, // Nếu không có voucher thì giảm giá = 0
        'payment_method' => $request->payment_method,
        'status' => 'pending',
    ]);

    // Thêm sản phẩm vào đơn hàng
    foreach ($cartItems as $item) {
        Order_item::create([
            'id_order' => $order->id,
            'id_variant' => $item->id_variant,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'subtotal' => $item->price * $item->quantity,
        ]);
    }

    // Xóa giỏ hàng sau khi đặt hàng
    Cart::where('id_user', Auth::id())->delete();
    // Xóa session voucher
    session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount']);

    // Cập nhật sản phẩm khi đặt hàng
    foreach ($cartItems as $item) {
        $variant = Variant::find($item['id_variant']);
        $variant->quantity -= $item['quantity'];
        $variant->save();
    }

    // Xử lý thanh toán
    switch ($order->payment_method) {
        case 'momo':
            return redirect()->route('momo.pay', ['order_id' => $order->id]);
        case 'vnpay':
            return redirect()->route('vnpay.pay', ['order_id' => $order->id]);
        case 'credit_card':
            return redirect()->route('creditcard.pay', ['order_id' => $order->id]);
        default:
            return redirect()->route('order.success')->with('success', 'Đơn hàng đã được đặt thành công!');
    }
}

    // Hiển thị trang đặt hàng thành công
    public function success()
    {
        return view('home.checkout-success');
    }

    // Lịch sử đơn hàng
    public function userOrders()
    {
        $orders = Order::where('id_user', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('home.orders', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function orderDetail($id)
    {
        $order = Order::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('home.order-detail', compact('order'));
    }
    private function calculateCartTotal()
{
    // Giả sử bạn có model Cart để lấy giỏ hàng của user
    $cartItems = Cart::where('id_user', auth()->id())->get();

    return $cartItems->sum(function ($item) {
        return $item->quantity * $item->price; // Tổng tiền = số lượng * giá sản phẩm
    });
}



}
