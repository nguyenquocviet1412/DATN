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
        'fullname',
        'phone',
        'shipping_address',
        'payment_method',
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
public function applyVoucher($voucherCode)
{
    $voucher = Voucher::where('code', $voucherCode)->where('status', 'active')->first();

    if (!$voucher) {
        return ['success' => false, 'message' => 'Voucher không hợp lệ hoặc đã hết hạn.'];
    }

    // Lấy tổng tiền giỏ hàng trước khi giảm giá
    $cartTotal = $this->calculateCartTotal();

    if ($voucher->min_order_value && $cartTotal < $voucher->min_order_value) {
        return ['success' => false, 'message' => 'Đơn hàng chưa đạt mức tối thiểu để áp dụng voucher.'];
    }

    $discountAmount = 0;

    if ($voucher->discount_type === 'percentage') {
        // Tính số tiền giảm giá theo %
        $discountAmount = ($cartTotal * $voucher->discount_value) / 100;

        // Nếu có giới hạn giảm tối đa, áp dụng giới hạn
        if ($voucher->max_discount) {
            $discountAmount = min($discountAmount, $voucher->max_discount);
        }
    } else {
        // Giảm giá cố định
        $discountAmount = $voucher->discount_value;
    }

    // Tính tổng tiền sau khi giảm giá
    $totalAfterDiscount = max(0, $cartTotal - $discountAmount);

    // Cập nhật thông tin vào bảng orders
    $this->update([
        'id_voucher' => $voucher->id,
        'discount_amount' => $discountAmount,
        'total_price' => $totalAfterDiscount, // Tổng tiền sau giảm giá
    ]);

    return [
        'success' => true,
        'message' => 'Áp dụng voucher thành công!',
        'discount' => $discountAmount,
        'total_before_discount' => $cartTotal, // Tổng tiền trước khi giảm giá
        'total_after_discount' => $totalAfterDiscount // Tổng tiền sau giảm giá
    ];
}

public function getTotalPriceAfterDiscountAttribute()
{
    $cartTotal = $this->orderItems()->sum('subtotal'); // Tổng tiền trước giảm giá

    if (!$this->voucher) {
        return $cartTotal; // Không có voucher, giữ nguyên tổng tiền
    }

    $voucher = $this->voucher;
    $discountAmount = 0;

    if ($voucher->discount_type === 'percentage') {
        // Tính giảm giá theo %
        $discountAmount = ($cartTotal * $voucher->discount_value) / 100;

        // Kiểm tra giới hạn giảm tối đa
        if ($voucher->max_discount) {
            $discountAmount = min($discountAmount, $voucher->max_discount);
        }
    } else {
        // Giảm giá theo số tiền cố định
        $discountAmount = $voucher->discount_value;
    }

    // Trả về tổng tiền sau giảm giá
    return max(0, $cartTotal - $discountAmount);
}

// Tính tổng tiền giỏ hàng
private function calculateCartTotal()
{
    return $this->orderItems()->sum('subtotal');
}
// Tính tổng tiền trước khi giảm giá
public function getTotalBeforeDiscountAttribute()
{
    return $this->orderItems->sum('subtotal');
}
const ORDER_STATUS = [
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

const PAYMENT_METHOD = [
    'COD' => 'Thanh toán khi nhận hàng',
    'momo' => 'Thanh toán qua momo',
    'wallet' => 'Thanh toán từ ví điện tử',
];
}
