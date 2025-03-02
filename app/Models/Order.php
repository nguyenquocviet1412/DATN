<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $appends = ['totalPrice'];

    protected $table = 'orders';


    protected $fillable = [
        'id_user',
        'id_voucher',
        'discount_amount',
        'total_price',
        'user_points',
        'points_earned',
        'shipping_address',
        'payment_status'
    ];
    public function user()
    {

        return $this->belongsTo(User::class, 'id_user'); // Giả sử cột khóa ngoại là id_user
    }

    public function orderItems()
    {
        return $this->hasMany(Order_item::class, 'id_order');
    }
    public function voucher()
{
    return $this->belongsTo(Voucher::class, 'id_voucher');
}
}
