<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart as CartModel; // Đổi tên alias tránh trùng với thư viện Cart
use App\Models\Order_item;
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
    $validated = $request->validate([
        'fullname' => 'required',
        'phone' => 'required',
        'shipping_address' => 'required',
        'payment_method' => 'required',
        'voucher_code' => 'nullable|string',
    ]);

    // Kiểm tra voucher
    $voucher = Voucher::where('code', $request->voucher_code)
        ->where('status', 'active')
        ->first();
    
    // Lấy giỏ hàng từ database
    $cartItems = CartModel::all();
    $cartTotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

    // Tính toán giảm giá
    $discountAmount = $voucher ? min($voucher->discount_value, $cartTotal) : 0;
    $totalAfterDiscount = $cartTotal - $discountAmount;

    // Tạo đơn hàng
    $order = Order::create([
        'customer_name' => $request->fullname,
        'customer_phone' => $request->phone,
        'shipping_address' => $request->shipping_address,
        'total_price' => $totalAfterDiscount,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
        'voucher_id' => $voucher ? $voucher->id : null,
        'discount_amount' => $discountAmount,
    ]);

    // Thêm sản phẩm vào đơn hàng
    foreach ($cartItems as $item) {
        Order_item::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'subtotal' => $item->price * $item->quantity,
        ]);
    }

    // Xóa giỏ hàng sau khi đặt hàng
    CartModel::truncate();

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
