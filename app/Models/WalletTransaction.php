<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions'; // Tên bảng

    protected $fillable = [
        'id_wallet',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'status'
    ];

    /**
     * Định nghĩa quan hệ với bảng Wallet
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'id_wallet');
    }
}
