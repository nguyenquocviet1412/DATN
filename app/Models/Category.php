<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Category extends Model
{
    use HasFactory, SoftDeletes; // Sử dụng SoftDeletes

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at']; // Trường deleted_at dùng để lưu thời gian xóa
    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }
}
