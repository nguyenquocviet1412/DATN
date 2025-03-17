<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientOrderController extends Controller
{
    // Trang thanh toán
    public function checkout()
    {
        $cart = session()->get('cart', []);

        // Tính tổng tiền trước giảm giá
        $cartTotalBeforeDiscount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Lấy giảm giá nếu có
        $cartDiscount = session()->get('cart_discount', 0);
        $cartTotalAfterDiscount = $cartTotalBeforeDiscount - $cartDiscount;

        return view('home.checkout', compact('cart', 'cartTotalBeforeDiscount', 'cartDiscount', 'cartTotalAfterDiscount'));
    }

    // Xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        // Kiểm tra voucher
        $voucher = Voucher::where('code', $request->voucher_code)
            ->where('status', 'active')
            ->first();
        $discountAmount = $voucher ? min($voucher->discount_value, session('cart_total_before_discount', 0)) : 0;
        $totalAfterDiscount = session('cart_total_before_discount', 0) - $discountAmount;

        // Tạo đơn hàng
        $order = Order::create([
            'id_user' => $user->id,
            'id_voucher' => $voucher ? $voucher->id : null,
            'discount_amount' => $discountAmount,
            'total_price' => $totalAfterDiscount,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // Thêm sản phẩm vào đơn hàng
        foreach ($cart as $item) {
            OrderItem::create([
                'id_order' => $order->id,
                'id_variant' => $item['id_variant'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        // Chuyển hướng đến trang thanh toán nếu không phải COD
        if ($request->payment_method !== 'cod') {
            return redirect()->route('payment.process', ['order_id' => $order->id]);
        }

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }

    // Hiển thị trang đặt hàng thành công
    public function success()
    {
        return view('checkout-success');
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
        return view('user.order-detail', compact('order'));
    }
    //Xử lý voucher
    public function applyVoucher(Request $request)
{
    $voucher = Voucher::where('code', $request->voucher_code)
                      ->where('status', 'active')
                      ->first();

    if (!$voucher) {
        return response()->json(['error' => 'Voucher không hợp lệ hoặc đã hết hạn'], 400);
    }

    $cartTotal = session()->get('cart_total_before_discount', 0);
    $discount = min($voucher->discount_value, $cartTotal);
    
    session()->put('cart_discount', $discount);

    return response()->json([
        'message' => 'Voucher áp dụng thành công!',
        'discount' => $discount,
        'total_after_discount' => $cartTotal - $discount
    ]);
}

}
