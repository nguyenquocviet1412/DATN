<?php
namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class MomoController extends Controller
{
    public function pay($order_id)
    {
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');

        if (!$partnerCode || !$accessKey || !$secretKey) {
            return redirect()->route('checkout')->with('error', 'Cấu hình Momo bị thiếu!');
        }

        $order = Order::findOrFail($order_id);
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $orderId = time() . "" . $order->id;
        $requestId = time() . "" . $order->id;
        $amount = $order->total_price;
        $orderInfo = "Thanh toán đơn hàng #" . $order->id;
        $redirectUrl = route('order.success');
        $ipnUrl = route('payment.process', ['order_id' => $order->id]);
        $extraData = "";

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'signature' => $signature
        ];

        $response = Http::post($endpoint, $data);
        $result = $response->json();

        if (isset($result['payUrl'])) {
            return redirect($result['payUrl']);
        }

        return redirect()->route('checkout')->with('error', 'Không thể kết nối với Momo.');
    }
}
