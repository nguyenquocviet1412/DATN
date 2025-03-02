<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\Wallet;

class Wallet_Transaction extends Controller
{
    public function show($id_wallet)
    {
        $wallet = Wallet::findOrFail($id_wallet);
        $transactions = WalletTransaction::where('id_wallet', $id_wallet)->orderBy('created_at', 'desc')->get();

        return view('admin.wallet.transactions', compact('wallet', 'transactions'));
    }
}
