<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_product',
        'id_order_item',
        'rating',
        'review',
        'status',
    ];

    /**
     * Quan hệ với bảng Users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Quan hệ với bảng Products
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    /**
     * Quan hệ với bảng OrderItems (để xác định sản phẩm đã mua)
     */
    public function orderItem()
    {
        return $this->belongsTo(Order_item::class, 'id_order_item');
    }
}
