<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'id_category',
        'price',
        'view',
        'status',
    ];

    /**
     * Quan hệ với bảng Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    /**
     * Quan hệ với bảng Variants (Các biến thể của sản phẩm)
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'id_product');
    }
}
