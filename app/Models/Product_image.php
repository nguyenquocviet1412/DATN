<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_variant',
        'image_url',
        'is_primary',
    ];

    /**
     * Quan hệ với bảng Variants (Sản phẩm biến thể)
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'id_variant');
    }
}
