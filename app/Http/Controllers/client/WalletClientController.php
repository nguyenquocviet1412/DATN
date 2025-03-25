<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = Wallet::where('id_user', $user->id)->first();
        if (!$wallet) {
            return redirect()->route('home')->with('error', 'Bạn chưa có ví. Hãy liên hệ hỗ trợ.');
        }
        $transactions = WalletTransaction::whereHas('wallet', function ($query) use ($user) {
            $query->where('id_user', $user->id);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('home.wallet', compact('wallet', 'transactions'));
    }
}
