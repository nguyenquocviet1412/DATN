<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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
        $orderInfo = "Thanh toan don hang #" . $order->id;
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
        
        $inputData = array(
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
        );
        
        ksort($inputData);
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $query .= '&';
            }
            $query .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        
        $vnp_Url .= "?" . $query;
        return redirect($vnp_Url);
    }
}

class PaypalController extends Controller
{
    public function pay($order_id)
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET');

        if (!$clientId || !$secret) {
            return redirect()->route('checkout')->with('error', 'Cấu hình PayPal bị thiếu!');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal')); 
        $paypalToken = $provider->getAccessToken();
        
        $order = Order::findOrFail($order_id);
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => $order->total_price,
                ]
            ]]
        ]);
        
        if (isset($response['id']) && $response['status'] == 'CREATED') {
            return redirect($response['links'][1]['href']);
        }
        return redirect()->route('checkout')->with('error', 'Lỗi khi kết nối PayPal.');
    }
}
