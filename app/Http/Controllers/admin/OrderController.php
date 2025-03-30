<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //hiển thị danh sách đơn hàng
    public function index()
    {
        $listOrder = Order::with('orderItems.variant.product')->orderByDesc('id')->get();

        return view('admin.order', compact('listOrder'));
    }

    //Trang hiện thị đơn hàng chi tiết
    public function show($id)
    {
        $order = Order::with(['user', 'voucher', 'orderItems.variant.product', 'orderItems.variant.color', 'orderItems.variant.size'])->findOrFail($id);

        return view('admin.detailorder', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::query()->findOrFail($id);
        if (!$order) {
            return redirect()->route('order.index');
        }
        return view('admin.editorder', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $order = Order::findOrFail($id);

    // Cập nhật phương thức thanh toán
    $order->payment_method = $request->input('payment_method');
    $order->save();

    $hasStatusError = false; // Cờ kiểm tra lỗi hoàn tiền
    $updatedStatus = false; // Cờ kiểm tra có cập nhật trạng thái không

    // Cập nhật trạng thái từng sản phẩm trong đơn hàng (order_items)
    foreach ($request->order_items as $itemId => $data) {
        $orderItem = Order_item::findOrFail($itemId);
        $previousStatus = $orderItem->status;

        // Nếu sản phẩm đã bị hủy hoặc hoàn tiền, bỏ qua không cập nhật
        if (in_array($previousStatus, ['cancelled', 'refunded'])) {
            $hasStatusError = true; // Đánh dấu có lỗi trạng thái
            continue; // Bỏ qua sản phẩm này, nhưng vẫn xử lý các sản phẩm khác
        }

        // Nếu trạng thái thay đổi từ return_processing → refunded thì hoàn tiền
        if ($previousStatus === 'return_processing' && $data['status'] === 'refunded') {
            $this->refundToWallet($order, $orderItem->subtotal);
        }

        // Cập nhật trạng thái sản phẩm
        $orderItem->status = $data['status'];
        $orderItem->save();
        $updatedStatus = true; // Đánh dấu có sản phẩm được cập nhật

        // Cập nhật trạng thái tổng của order
        if ($previousStatus !== $data['status']) {
            $order->payment_status = $data['status'];
            $order->save();
        }
    }

    // Ghi log nếu có cập nhật thành công
    if ($updatedStatus) {
        LogHelper::logAction('Cập nhật đơn hàng: ' . $order->id);
    }

    // Kiểm tra nếu có lỗi hoàn tiền
    if ($hasStatusError) {
        return redirect()->route('order.index')->with('error', 'Một số sản phẩm không được phép cập nhật trạng thái.');
    }

    return redirect()->route('order.index')->with('success', 'Cập nhật đơn hàng thành công');
}

    public function confirmReceipt($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->payment_status = 'completed';
            $order->save();

            return response()->json(['message' => 'Cập nhật thành công']);
        }

        return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
    }

    //Phương thức hoàn tiền hàng
    private function refundToWallet(Order $order, $refundAmount)
{
    $user = $order->user;
    $wallet = Wallet::where('id_user', $user->id)->first();
    // Kiểm tra xem người dùng có ví hay không
    if (!$wallet) {
        // Nếu không có ví, tạo một ví mới cho người dùng
        $wallet = Wallet::create([
            'id_user' => $user->id,
            'balance' => 0,
            'status' => 'active'
        ]);
    }

    // Lưu giao dịch trước khi cập nhật số dư ví
    WalletTransaction::create([
        'id_wallet' => $wallet->id,
        'transaction_type' => 'refund',
        'amount' => $refundAmount,
        'balance_before' => $wallet->balance,
        'balance_after' => $wallet->balance + $refundAmount,
        'description' => 'Hoàn tiền cho đơn hàng #' . $order->id,
        'status' => 'completed'
    ]);

    // Cập nhật số dư ví
    $wallet->update([
        'balance' => $wallet->balance + $refundAmount
    ]);

    // Log
    LogHelper::logAction('Xác nhận hoàn tiền ' . number_format($refundAmount) . ' VNĐ cho đơn hàng #' . $order->id);
}
}
