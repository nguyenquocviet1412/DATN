<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_product'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
