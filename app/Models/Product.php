<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'id_category',
        'price',
        'view',
        'status',
    ];

    // Nếu cần khai báo thêm cột deleted_at (không bắt buộc nếu đã có migration)
    protected $dates = ['deleted_at'];
    

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
        return $this->hasMany(Variant::class, 'id_product','id');
    }

    /**
     * Lấy ảnh đại diện của sản phẩm (ảnh đầu tiên của biến thể đầu tiên)
     */
    public function getThumbnailAttribute()
    {
        $firstVariant = $this->variants()->with('images')->first();
        if ($firstVariant && $firstVariant->images->isNotEmpty()) {
            return asset($firstVariant->images->first()->image_url);
        }
        return asset('default-image.jpg');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'id_product');
    }

    public function images()
    {
        return $this->hasManyThrough(Product_image::class, Variant::class, 'id_product', 'id_variant');
    }

    public function getAverageRatingAttribute()
    {
        return $this->rates()->avg('rating');
    }
}
