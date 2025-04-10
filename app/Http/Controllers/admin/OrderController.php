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
    //Kiểm tra phương thức thanh toán
    $validMethods = ['COD', 'momo'];
    $newPaymentMethod = $request->input('payment_method');

        // Kiểm tra phương thức thanh toán có hợp lệ
        if (!in_array($newPaymentMethod, $validMethods)) {
            return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
    // Kiểm tra trạng thái thanh toán của đơn hàng
    $validStastus = ['unpaid', 'pay'];
    $newPay = $request->status;
    if (!in_array($newPay, $validStastus)) {
        return redirect()->back()->with('error', 'Trạng thái thanh toán không hợp lệ.');
    }

    // Lưu giá trị cũ để so sánh
    $oldPaymentMethod = $order->payment_method;
    $newPaymentMethod = $request->input('payment_method');

    // Cập nhật phương thức thanh toán nếu có thay đổi
    if ($oldPaymentMethod !== $newPaymentMethod) {
        $order->payment_method = $newPaymentMethod;

        // Ghi log thay đổi phương thức thanh toán
        LogHelper::logAction('Đơn hàng #' . $order->id . ' thay đổi phương thức thanh toán từ "' . $oldPaymentMethod . '" sang "' . $newPaymentMethod . '"');
    }

    $newStatus = $request->input('payment_status');
    $previousStatus = $order->payment_status;

    // Kiểm tra thứ tự trạng thái
    $statusFlow = [
        'pending' => ['confirmed'],
        'confirmed' => ['preparing'],
        'preparing' => ['handed_over'],
        'handed_over' => ['shipping'],
        'shipping' => ['completed'],
        'completed' => ['return_processing'],
        'return_processing' => ['shop_refunded'],
        'shop_refunded' => ['customer_confirmed_refund'],
        'customer_confirmed_refund' => ['refunded'],
        'refunded' => [],
        'cancelled' => [],
        'failed' => [],
    ];

    // Không cho chuyển về trạng thái trước hoặc nhảy cóc
    if (!in_array($newStatus, $statusFlow[$previousStatus] ?? [])) {
        return redirect()->back()->with('error', 'Không thể chuyển trạng thái! Vui lòng thực hiện theo đúng thứ tự xử lý.');
    }

    // Cập nhật trạng thái đơn hàng
    $order->payment_status = $newStatus;
    // Cập nhật trạng thái thanh toán
    $order->status = $newPay;

    $order->save();

    // Ghi log trạng thái
    LogHelper::logAction('Cập nhật trạng thái đơn hàng #' . $order->id . ' thành "' . $newStatus . '"');
    // Ghi log trạng thái thanh toán
    LogHelper::logAction('Cập nhật trạng thái thanh toán đơn hàng #' . $order->id . ' thành "' . $newPay . '"');

    return redirect()->back()->with('success', 'Cập nhật đơn hàng thành công');
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
