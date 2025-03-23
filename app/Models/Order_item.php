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
        'subtotal',
        'status',
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
    const ITEM_STATUS = [
        'pending' => 'Chờ xử lý',  // Đã đặt hàng nhưng chưa được xử lý
        'confirmed' => 'Đã xác nhận',  // Đơn hàng đã được xác nhận
        'preparing' => 'Đang chuẩn bị hàng',  // Đang đóng gói sản phẩm
        'handed_over' => 'Đã bàn giao cho đơn vị vận chuyển',  // Giao cho đơn vị vận chuyển
        'shipping' => 'Đang vận chuyển',  // Đang giao hàng
        'completed' => 'Giao hàng thành công',  // Đã giao hàng thành công & hoàn tất đơn hàng
        'cancelled' => 'Đã hủy',  // Đơn hàng bị hủy
        'failed' => 'Thất bại',  // Thanh toán thất bại hoặc lỗi đơn hàng
        'return_processing' => 'Đang xử lý trả hàng hoàn tiền',  // Đơn hàng đang trong quá trình xét duyệt trả hàng
        'refunded' => 'Đã hoàn tiền'  // Hoàn tiền cho khách hàng
    ];

}
