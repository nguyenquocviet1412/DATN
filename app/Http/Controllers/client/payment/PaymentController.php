<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Kiểm tra xem đơn hàng có phương thức thanh toán không
        if (!$order->payment_method) {
            return redirect()->route('checkout')->with('error', 'Vui lòng chọn phương thức thanh toán.');
        }

        switch ($order->payment_method) {
            case 'momo':
                return redirect()->route('momo.pay', ['order_id' => $order_id]);
            case 'vnpay':
                return redirect()->route('vnpay.pay', ['order_id' => $order_id]);
            case 'paypal':
                return redirect()->route('paypal.pay', ['order_id' => $order_id]);
            case 'credit_card':
                return redirect()->route('creditcard.pay', ['order_id' => $order_id]);
            default:
                return redirect()->route('checkout')->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
    }
}
