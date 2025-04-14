<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User_voucher;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart as CartModel; // Đổi tên alias tránh trùng với thư viện Cart
use App\Models\Order_item;
use App\Models\Rate;
use App\Models\Variant;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ClientOrderController extends Controller
{
    // Trang thanh toán
    public function checkout()
    {
        session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount']);
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
        $cartTotalBeforeDiscount = $cartItems->sum(fn($item) => $item->quantity * $item->price) + 30000; // 30000 là phí vận chuyển cố định

        // Giả lập giảm giá nếu có mã giảm giá
        $cartDiscount = session('cart_discount', 0);

        // Tổng tiền sau giảm giá
        $cartTotalAfterDiscount = max(0, $cartTotalBeforeDiscount - $cartDiscount);

        return view('home.checkout', compact('cartItems', 'cartTotalBeforeDiscount', 'cartDiscount', 'cartTotalAfterDiscount'));
    }
    //Xử lý voucher
    public function applyVoucher(Request $request)
    {
        // Xóa session cũ để đảm bảo luôn cập nhật voucher mới
        session()->forget(['id_voucher', 'voucher_code', 'discount_amount', 'cart_total_after_discount']);

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

        if ($voucher->min_order_value && $cartTotal < $voucher->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng chưa đạt mức tối thiểu để áp dụng voucher.'
            ]);
        }

        if ($voucher->quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher này đã hết số lượng sử dụng.'
            ]);
        }

        $userVoucherCount = User_voucher::where('id_user', $user->id)
            ->where('id_voucher', $voucher->id)
            ->count();

        if ($voucher->usage_limit && $userVoucherCount >= $voucher->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng voucher này quá số lần cho phép.'
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

        $cartTotalAfterDiscount = max(0, $cartTotal - $discountAmount) + 30000; // 30000 là phí vận chuyển cố định

        // Cập nhật session mới
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
        //Danh sách giỏ hàng trống
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Không có sản phẩm trong giỏ hàng!.');
        }
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
                $voucher->used_count += 1;
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


        //Thanh toán momo
        if ($request->payment_method === 'momo') {
            // Tạo yêu cầu thanh toán MoMo
            function execPostRequest($url, $data)
            {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data)
                    )
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
            if ($totalAfterDiscount == 0 || $totalAfterDiscount == null) {
                $amount = $cartTotal + $shippingFee;
            } else {
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
            $data = array(
                'partnerCode' => $partnerCode,
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
                'signature' => $signature
            );
            $result = execPostRequest($endpoint, json_encode($data));
            // dd([$result,$amount,$ipnUrl]);
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there
            return redirect()->to($jsonResult['payUrl']);
        }
        if ($request->payment_method === 'cod') {
            // Thanh toán tiền mặt
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
                'status' => 'unpaid',
            ]);

            // Tính tổng số lượng sản phẩm trong đơn hàng
            $totalQuantity = $cartItems->sum('quantity');

            // Tránh chia cho 0 nếu không có sản phẩm
            $discountPerItem = ($voucher && $totalQuantity > 0) ? $discountAmount / $totalQuantity : 0;

            $remainingDiscount = $discountAmount; // Số tiền giảm giá còn lại để phân bổ

            // Thêm sản phẩm vào đơn hàng với giá đã giảm
            foreach ($cartItems as $item) {
                $originalPrice = $item->price; // Giá gốc của sản phẩm
                $discountedPrice = max(0, $originalPrice - $discountPerItem); // Không để giá âm

                // Nếu giá sau giảm bằng 0, phần giảm dư sẽ được dồn sang các sản phẩm khác
                $remainingDiscount -= ($originalPrice - $discountedPrice) * $item->quantity;

                Order_item::create([
                    'id_order' => $order->id,
                    'id_variant' => $item->id_variant,
                    'quantity' => $item->quantity,
                    'price' => $discountedPrice, // Giá sau khi trừ chiết khấu
                    'subtotal' => $discountedPrice * $item->quantity, // Thành tiền sau khi trừ chiết khấu
                    'status' => session('payment_method'),
                ]);
            }

            // Nếu còn tiền giảm giá chưa sử dụng hết, phân bổ lại cho các sản phẩm có giá cao hơn
            if ($remainingDiscount > 0) {
                foreach ($order->orderItems as $orderItem) {
                    if ($remainingDiscount <= 0) break;

                    $additionalDiscount = min($orderItem->price, $remainingDiscount / $orderItem->quantity);
                    $newPrice = max(0, $orderItem->price - $additionalDiscount);

                    $remainingDiscount -= ($orderItem->price - $newPrice) * $orderItem->quantity;

                    $orderItem->update([
                        'price' => $newPrice,
                        'subtotal' => $newPrice * $orderItem->quantity
                    ]);
                }
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

            return $this->success();
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
                'status' => 'pay',
            ]);

            // Tính tổng số lượng sản phẩm trong đơn hàng
            $totalQuantity = $cartItems->sum('quantity');

            // Tránh chia cho 0 nếu không có sản phẩm
            $discountPerItem = ($voucher && $totalQuantity > 0) ? $discountAmount / $totalQuantity : 0;

            $remainingDiscount = $discountAmount; // Số tiền giảm giá còn lại để phân bổ

            // Thêm sản phẩm vào đơn hàng với giá đã giảm
            foreach ($cartItems as $item) {
                $originalPrice = $item->price; // Giá gốc của sản phẩm
                $discountedPrice = max(0, $originalPrice - $discountPerItem); // Không để giá âm

                // Nếu giá sau giảm bằng 0, phần giảm dư sẽ được dồn sang các sản phẩm khác
                $remainingDiscount -= ($originalPrice - $discountedPrice) * $item->quantity;

                Order_item::create([
                    'id_order' => $order->id,
                    'id_variant' => $item->id_variant,
                    'quantity' => $item->quantity,
                    'price' => $discountedPrice, // Giá sau khi trừ chiết khấu
                    'subtotal' => $discountedPrice * $item->quantity, // Thành tiền sau khi trừ chiết khấu
                    'status' => session('payment_method'),
                ]);
            }

            // Nếu còn tiền giảm giá chưa sử dụng hết, phân bổ lại cho các sản phẩm có giá cao hơn
            if ($remainingDiscount > 0) {
                foreach ($order->orderItems as $orderItem) {
                    if ($remainingDiscount <= 0) break;

                    $additionalDiscount = min($orderItem->price, $remainingDiscount / $orderItem->quantity);
                    $newPrice = max(0, $orderItem->price - $additionalDiscount);

                    $remainingDiscount -= ($orderItem->price - $newPrice) * $orderItem->quantity;

                    $orderItem->update([
                        'price' => $newPrice,
                        'subtotal' => $newPrice * $orderItem->quantity
                    ]);
                }
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

            return $this->success();
        }

        return response()->json(['message' => 'Thanh toán thất bại'], 400);
    }

    // Hiển thị trang đặt hàng thành công
    public function success()
    {
        // Lấy đơn hàng cuối cùng của khách (nếu đã đăng nhập)
        $order = Order::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        // Nếu không có đơn hàng nào, chuyển hướng về trang giỏ hàng
        if (!$order) {
            return redirect()->route('cart.index')->with('message', 'Không có đơn hàng nào để hiển thị.');
        }

        return view('home.checkout-success', compact('order'));
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
        $user = auth()->user();
        $order = Order::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        // Lấy đánh giá của người dùng
        $rating = Rate::where('id_user', $user->id)->get();
        return view('home.order-detail', compact('order', 'user', 'rating'));
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
        // Cập nhật nhận hàng sẽ cập nhật thanh toán
        if ($order->payment_status == 'completed') {
            $order->update(['status' => 'pay']);
        }

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
            return back()->with('error', 'Đơn hàng này không thể trả hàng vì đã quá 7 ngày.');
        }

        // Cập nhật trạng thái đơn hàng
        $order->payment_status = 'return_processing';
        $order->save();

        return back()->with('success', 'Đơn hàng đang được xử lý trả hàng.');
    }
    // Xác nhận đã nhận tiền trả hàng
    public function submitRefundConfirmation(Request $request)
    {
        $orderId = $request->input('id_order');

        // Tìm đơn hàng theo ID và người dùng đang đăng nhập, và đang có trạng thái 'shop_refunded'
        $order = Order::where('id', $orderId)
            ->where('id_user', auth()->id())
            ->where('payment_status', 'shop_refunded')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng phù hợp để xác nhận hoàn tiền.');
        }

        // Cập nhật trạng thái đơn hàng thành 'customer_confirmed_refund'
        $order->update(['payment_status' => 'customer_confirmed_refund']);
        $order->save();

        return redirect()->back()->with('success', 'Cảm ơn bạn đã xác nhận đã nhận được tiền cho đơn hàng #' . $order->id);
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
        //Kiểm tra xem đơn hàng đã thanh toán trước chưa
        if ($order->status == 'pay') {
            //Chuyển trang thái đơn hàng thành hoàn tiền
            $order->update(['payment_status' => 'return_processing']);
        }

        $order->save();

        // Cập nhật trạng thái tất cả sản phẩm trong đơn hàng
        $order->orderItems()->update(['status' => 'cancelled']);

        // Cập nhật số lượng sản phẩm trong kho
        foreach ($order->orderItems as $item) {
            $variant = Variant::find($item->id_variant);
            $variant->quantity += $item->quantity;
            $variant->save();
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
