<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreditCardController extends Controller
{
    public function pay($order_id)
    {
        $api_key = env('CREDIT_CARD_API_KEY');
        $api_secret = env('CREDIT_CARD_API_SECRET');

        if (!$api_key || !$api_secret) {
            return redirect()->route('checkout')->with('error', 'Cấu hình thanh toán thẻ tín dụng bị thiếu!');
        }

        $order = Order::findOrFail($order_id);
        $paymentGatewayUrl = "https://api.creditcardgateway.com/pay";
        $returnUrl = route('order.success');

        $txnRef = time() . "" . $order->id;
        $orderInfo = "Thanh toán đơn hàng #" . $order->id;
        $amount = $order->total_price * 100;

        $inputData = [
            "api_key" => $api_key,
            "amount" => $amount,
            "currency" => "VND",
            "txn_ref" => $txnRef,
            "order_info" => $orderInfo,
            "return_url" => $returnUrl,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $paymentGatewayUrl .= "?" . $query;

        Log::info('Chuyển hướng đến cổng thanh toán thẻ tín dụng', $inputData);

        return redirect($paymentGatewayUrl);
    }
}
