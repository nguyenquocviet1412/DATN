<?php
namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;

class VnPayController extends Controller
{
    public function pay($order_id)
    {
        $vnp_TmnCode = env('VNPAY_TMNCODE');
        $vnp_HashSecret = env('VNPAY_HASHSECRET');

        if (!$vnp_TmnCode || !$vnp_HashSecret) {
            return redirect()->route('checkout')->with('error', 'Cấu hình VnPay bị thiếu!');
        }

        $order = Order::findOrFail($order_id);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('order.success');

        $vnp_TxnRef = time() . "" . $order->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order->id;
        $vnp_Amount = $order->total_price * 100;

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnp_Url .= "?" . $query;

        return redirect($vnp_Url);
    }
}
