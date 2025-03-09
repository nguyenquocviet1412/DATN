<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    /**
     * Hiển thị danh sách giao dịch với bộ lọc thời gian và loại giao dịch.
     */
    public function index(Request $request)
{
    $query = WalletTransaction::with(['wallet.user']); // Load thông tin người dùng qua wallet

    // Lọc theo loại giao dịch
    if ($request->has('transaction_type') && $request->transaction_type) {
        $query->where('transaction_type', $request->transaction_type);
    }

    // Lọc theo trạng thái
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    // Lọc theo ngày bắt đầu
    if ($request->has('from_date') && $request->from_date) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    // Lọc theo ngày kết thúc
    if ($request->has('to_date') && $request->to_date) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    $transactions = $query->paginate(10);
    return view('admin.wallet_transactions.index', compact('transactions'));
}
    /**
     * Hiển thị chi tiết giao dịch.
     */
    public function show($id)
    {
        $transaction = WalletTransaction::findOrFail($id);
        return view('admin.wallet_transactions.show', compact('transaction'));
    }

    /**
     * Xóa giao dịch (nếu cần, phụ thuộc vào quyền hạn admin).
     */
    public function destroy($id)
    {
        $transaction = WalletTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.wallet_transactions.index')->with('success', 'Giao dịch đã được xóa.');
    }
}
