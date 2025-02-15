<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_voucher',
        'is_used',
    ];

    // Quan hệ với bảng Users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Quan hệ với bảng Vouchers
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }
}
