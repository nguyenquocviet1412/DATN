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

   // Quan hệ với bảng ProductImage (Ảnh sản phẩm)
   public function images()
   {
       return $this->hasMany(Product_image::class, 'id_variant'); // Sửa từ Image thành ProductImage
   }

    /**
     * Lấy ảnh đầu tiên của biến thể
     */
    public function getThumbnailAttribute()
    {
        return $this->images()->exists() ? asset($this->images->first()->image_url) : asset('default-image.jpg');
    }

    
}
