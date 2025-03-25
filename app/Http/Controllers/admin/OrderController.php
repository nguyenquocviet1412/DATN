<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
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

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách đơn hàng');
        return view('admin.order', compact('listOrder'));
    }

    //Trang hiện thị đơn hàng chi tiết
    public function show($id)
    {
        $order = Order::with(['user', 'voucher', 'orderItems.variant.product', 'orderItems.variant.color', 'orderItems.variant.size'])->findOrFail($id);
        // Ghi log
        LogHelper::logAction('Xem chi tiết đơn hàng: ' . $order->id);
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
    $previousStatus = $order->payment_status; // Lưu trạng thái trước đó

    // Kiểm tra nếu đơn hàng đã bị hủy hoặc đã hoàn tiền
    if (in_array($order->payment_status, ['cancelled', 'refunded'])) {
        return redirect()->route('order.index')->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã bị hủy hoặc hoàn tiền.');
    }
    // Cập nhật trạng thái đơn hàng và phương thức thanh toán
    $order->payment_status = $request->input('payment_status');
    $order->payment_method = $request->input('payment_method');
    $order->save();

    // Nếu trạng thái thay đổi từ return_processing → refunded thì hoàn tiền
    if ($previousStatus === 'return_processing' && $request->input('payment_status') === 'refunded') {
        $this->refundToWallet($order);
    }

    // Cập nhật trạng thái của các order_items nếu trạng thái trước đó giống với trạng thái tổng
    DB::table('order_items')
        ->where('id_order', $order->id)
        ->where('status', $previousStatus) // Chỉ cập nhật nếu giống trạng thái tổng trước đó
        ->update(['status' => $order->payment_status]);

    // Ghi log
    LogHelper::logAction('Cập nhật đơn hàng: ' . $order->id);
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
    private function refundToWallet(Order $order)
{

    $user = $order->user;
    $wallet = Wallet::where('id_user', $user->id)->first();

    if (!$wallet) {
        return redirect()->route('order.index')->with('error', 'Người dùng chưa có ví để hoàn tiền.');
    }

    $refundAmount = $order->total_price; // Số tiền hoàn lại

    // Lưu giao dịch trước khi cập nhật số dư ví
    WalletTransaction::create([
        'id_wallet' => $wallet->id,
        'transaction_type' => 'refund',
        'amount' => $refundAmount,
        'balance_before' => $wallet->balance,
        'balance_after' => $wallet->balance + $refundAmount,
        'description' => 'Hoàn tiền đơn hàng #' . $order->id,
        'status' => 'completed'
    ]);

    // Cập nhật số dư ví
    $wallet->update([
        'balance' => $wallet->balance + $refundAmount
    ]);
}
}
