<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'balance',
        'currency',
        'status',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function transactions()
{
    return $this->hasMany(WalletTransaction::class, 'id_wallet');
}

}
