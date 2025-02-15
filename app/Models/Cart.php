<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_variant',
        'quantity',
        'price',
    ];
    // Quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Quan hệ với bảng variants
    public function productVariant()
    {
        return $this->belongsTo(Variant::class, 'id_variant');
    }
}
