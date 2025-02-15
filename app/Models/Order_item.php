<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_order',
        'id_variant',
        'quantity',
        'price',
        'subtotal'
    ];
    // Quan hệ với bảng Variant
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'id_variant');
    }
    // Quan hệ với bảng Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

}
