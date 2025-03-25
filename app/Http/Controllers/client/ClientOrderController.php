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
use App\Models\Wallet;
use App\Models\WalletTransaction;
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
        //Danh sách giỏ hàng trống
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Không có sản phẩm trong giỏ hàng!.');
        }
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

    $user = Auth::user();
    $cartTotal = $this->calculateCartTotal();

    // Kiểm tra nếu đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher
    if ($voucher->min_order_value && $cartTotal < $voucher->min_order_value) {
        return response()->json([
            'success' => false,
            'message' => 'Đơn hàng chưa đạt mức tối thiểu để áp dụng voucher.'
        ]);
    }
    // Kiểm tra số lượng voucher còn lại
    if ($voucher->quantity <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Voucher này đã hết số lượng sử dụng.'
        ]);
    }

    // Kiểm tra số lần user đã sử dụng voucher
    $userVoucherCount = User_voucher::where('id_user', $user->id)
        ->where('id_voucher', $voucher->id)
        ->count();

    if ($voucher->usage_limit && $userVoucherCount >= $voucher->usage_limit) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn đã sử dụng voucher này quá số lần cho phép.'
        ]);
    }

    // Tính giảm giá
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

    // Lưu voucher vào session
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
        // Lưu thông tin vào session để sử dụng khi đặt hàng
        session([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
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
                $voucher->used_count +=1;
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

        // Tính toán giảm giá
        $discountAmount = session('discount_amount');
        $totalAfterDiscount = session('cart_total_after_discount');
        // Nếu không có voucher, total_price = tổng tiền sản phẩm + phí ship


        //Thanh toán momo
        if ($request->payment_method === 'momo') {
            // Tạo yêu cầu thanh toán MoMo
            function execPostRequest($url, $data)
                {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data))
                    );
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    //execute post
                    $result = curl_exec($ch);
                    //close connection
                    curl_close($ch);
                    return $result;
                }


                $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


                $partnerCode = 'MOMOBKUN20180529';
                $accessKey = 'klm05TvNBzhg7h7j';
                $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
                $orderInfo = "Thanh toán qua MoMo";
                if($totalAfterDiscount == 0 || $totalAfterDiscount == null){
                    $amount = $cartTotal + $shippingFee;
                }else{
                    $amount = $totalAfterDiscount;
                }
                $orderId = time() . "";
                $redirectUrl = route('momo.ipn');  // Chuyển hướng khi thành công
                $ipnUrl = route('momo.ipn'); // URL nhận phản hồi từ MoMo
                $extraData = "";

                    $requestId = time() . "";
                    $requestType = "payWithATM";
                    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                    //before sign HMAC SHA256 signature
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $secretKey);
                    $data = array('partnerCode' => $partnerCode,
                        'partnerName' => "Test",
                        "storeId" => "MomoTestStore",
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature);
                    $result = execPostRequest($endpoint, json_encode($data));
                    // dd([$result,$amount,$ipnUrl]);
                    $jsonResult = json_decode($result, true);  // decode json

                    //Just a example, please check more in there
                    return redirect()->to($jsonResult['payUrl']);
        }
        if ($request->payment_method === 'cod') {
            // Thanh toán tiền mặt
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
            'fullname' => session('fullname'),
            'phone' => session('phone'),
            'shipping_address' => session('shipping_address'),
            'id_user' => Auth::id(),
            'total_price' => $voucher ? $totalAfterDiscount : $cartTotal + $shippingFee, // Nếu không có voucher thì cộng phí ship
            'id_voucher' => $voucher ? $voucher->id : null,
            'discount_amount' => $voucher ? $discountAmount : 0, // Nếu không có voucher thì giảm giá = 0
            'payment_method' => session('payment_method'),
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
                'status' => 'pending',
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        Cart::where('id_user', Auth::id())->delete();
        // Xóa session voucher
        session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount', 'fullname', 'phone', 'shipping_address', 'payment_method']);

        // Cập nhật sản phẩm khi đặt hàng
        foreach ($cartItems as $item) {
            $variant = Variant::find($item['id_variant']);
            $variant->quantity -= $item['quantity'];
            $variant->save();
        }

        return view('home.checkout-success');
    }
//Thanh toán bằng ví
    if ($request->payment_method === 'wallet') {
        // Lấy thông tin ví của người dùng
        $wallet = Wallet::where('id_user', $user->id)->first();

        if (!$wallet) {
            return response()->json(['error' => 'Bạn chưa có ví tiền!'], 400);
        }

        $totalPrice = $voucher ? $totalAfterDiscount : $cartTotal + $shippingFee;

        // Kiểm tra số dư ví
        if ($wallet->balance < $totalPrice) {
            return response()->json(['error' => 'Số dư ví không đủ để thanh toán!'], 400);
        }

        // Cập nhật số dư ví
        $wallet->balance -= $totalPrice;
        $wallet->save();



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
            'fullname' => session('fullname'),
            'phone' => session('phone'),
            'shipping_address' => session('shipping_address'),
            'id_user' => Auth::id(),
            'total_price' => $voucher ? $totalAfterDiscount : $cartTotal + $shippingFee, // Nếu không có voucher thì cộng phí ship
            'id_voucher' => $voucher ? $voucher->id : null,
            'discount_amount' => $voucher ? $discountAmount : 0, // Nếu không có voucher thì giảm giá = 0
            'payment_method' => session('payment_method'),
            'status' => 'pending',
        ]);

        // Lưu giao dịch vào bảng wallet_transactions
        WalletTransaction::create([
            'id_wallet' => $wallet->id,
            'transaction_type' => 'purchase',
            'amount' => -$totalPrice,
            'balance_before' => $wallet->balance + $totalPrice,
            'balance_after' => $wallet->balance,
            'description' => 'Thanh toán đơn hàng #' . $order->id,
            'status' => 'completed'
        ]);
        // Thêm sản phẩm vào đơn hàng
        foreach ($cartItems as $item) {
            Order_item::create([
                'id_order' => $order->id,
                'id_variant' => $item->id_variant,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
                'status' => 'pending',
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        Cart::where('id_user', Auth::id())->delete();
        // Xóa session voucher
        session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount', 'fullname', 'phone', 'shipping_address', 'payment_method']);

        // Cập nhật sản phẩm khi đặt hàng
        foreach ($cartItems as $item) {
            $variant = Variant::find($item['id_variant']);
            $variant->quantity -= $item['quantity'];
            $variant->save();
        }

        return view('home.checkout-success');
    }
}

    //Lưu thông tin khi thanh toán MOMO thành công
    public function handleMomoIPN(Request $request)
{
    $data = $request->all();

    if ($data['resultCode'] == 0) { // Thanh toán thành công
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
            'fullname' => session('fullname'),
            'phone' => session('phone'),
            'shipping_address' => session('shipping_address'),
            'id_user' => Auth::id(),
            'total_price' => $voucher ? $totalAfterDiscount : $cartTotal + $shippingFee, // Nếu không có voucher thì cộng phí ship
            'id_voucher' => $voucher ? $voucher->id : null,
            'discount_amount' => $voucher ? $discountAmount : 0, // Nếu không có voucher thì giảm giá = 0
            'payment_method' => session('payment_method'),
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
                'status' => 'pending',
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        Cart::where('id_user', Auth::id())->delete();
        // Xóa session voucher
        session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount', 'fullname', 'phone', 'shipping_address', 'payment_method']);

        // Cập nhật sản phẩm khi đặt hàng
        foreach ($cartItems as $item) {
            $variant = Variant::find($item['id_variant']);
            $variant->quantity -= $item['quantity'];
            $variant->save();
        }

        return view('home.checkout-success');
    }

    return response()->json(['message' => 'Thanh toán thất bại'], 400);
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

    //Cập nhật trạng thái đơn hàng đã nhận hàng
    public function markAsReceived($id)
    {
        $order = Order::where('id', $id)->where('payment_status', 'shipping')->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Không thể cập nhật đơn hàng.');
        }

        // Cập nhật trạng thái đơn hàng
        $order->update(['payment_status' => 'completed']);

        // Cập nhật trạng thái tất cả sản phẩm trong đơn hàng
        $order->orderItems()->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Bạn đã nhận hàng thành công!');
    }
    //Trả hàng
    public function returnItem(Request $request, Order $order, Order_item $item)
    {
        // Kiểm tra thời gian trả hàng (chỉ trong vòng 7 ngày)
        $orderDate = $order->updated_at;
        if (now()->diffInDays($orderDate) > 7) {
            return back()->with('error', 'Sản phẩm này không thể trả hàng vì đã quá 7 ngày.');
        }

        // Cập nhật trạng thái sản phẩm trong đơn hàng
        $item->status = 'return_processing';
        $item->save();

        // Kiểm tra nếu có ít nhất 1 sản phẩm được trả hàng -> Cập nhật trạng thái tổng thể đơn hàng
        if ($order->orderItems->where('status', 'return_processing')->count() > 0) {
            $order->payment_status = 'return_processing';
            $order->save();
        }

        return back()->with('success', 'Sản phẩm đang được xử lý trả hàng.');
    }
    // Hủy đơn hàng
    public function cancel(Order $order)
{
    // Kiểm tra trạng thái đơn hàng có thể hủy không
    if (!in_array($order->payment_status, ['pending', 'confirmed', 'preparing'])) {
        return redirect()->back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này.');
    }

    // Cập nhật trạng thái đơn hàng thành "cancelled"
    $order->payment_status = 'cancelled';
    $order->save();

    // Cập nhật trạng thái tất cả sản phẩm trong đơn hàng
    $order->orderItems()->update(['status' => 'cancelled']);

    // Cập nhật số lượng sản phẩm trong kho
    foreach ($order->orderItems as $item) {
        $variant = Variant::find($item->id_variant);
        $variant->quantity += $item->quantity;
        $variant->save();
    }

    // Hoàn tiền vào ví nếu thanh toán không phải là COD
    if (strtolower($order->payment_method) !== 'cod') {
        $wallet = Wallet::where('id_user', $order->id_user)->first();

        if (!$wallet) {
            return redirect()->back()->with('error', 'Không tìm thấy ví của khách hàng.');
        }

        // Lưu số dư trước khi cập nhật
        $balance_before = $wallet->balance;

        // Cộng lại số tiền vào ví
        $wallet->balance += $order->total_price;
        $wallet->save();

        // Lưu lịch sử giao dịch ví
        WalletTransaction::create([
            'id_wallet'      => $wallet->id,
            'transaction_type' => 'refund',
            'amount'         => $order->total_price,
            'balance_before' => $balance_before,
            'balance_after'  => $wallet->balance,
            'description'    => 'Hoàn tiền đơn hàng #' . $order->id,
            'status'         => 'completed'
        ]);
    }

    return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
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
