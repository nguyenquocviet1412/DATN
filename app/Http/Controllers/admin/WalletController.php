<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')->get(); // Lấy danh sách ví cùng thông tin user
        return view('admin.wallet.index', compact('wallets'));
    }

    public function toggleStatus($id)
{
    $wallet = Wallet::findOrFail($id);
    $wallet->status = $wallet->status === 'active' ? 'inactive' : 'active'; 
    $wallet->save();

    return back()->with('success', 'Cập nhật trạng thái thành công!');
}

}
