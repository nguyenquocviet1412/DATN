<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_color',
        'id_size',
        'price',
        'quantity',
        'status',
    ];

      // Quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    // Quan hệ với màu sắc
    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color');
    }

    // Quan hệ với size
    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size');
    }

    // Quan hệ với bảng OrderItem
    public function orderItems()
    {
        return $this->hasMany(Order_item::class, 'id_variant');
    }
}
