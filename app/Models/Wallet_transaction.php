<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet_transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_wallet',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'status',
    ];

    // Quan hệ với bảng Wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'id_wallet');
    }
}
