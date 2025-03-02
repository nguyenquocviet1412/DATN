<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'max_discount',
        'start_date',
        'end_date',
        'usage_limit',
        'quantity',
        'used_count',
        'status'
    ];

    // Quan hệ với bảng user_voucher
    public function userVouchers()
    {
        return $this->hasMany(User_voucher::class, 'id_voucher');
    }

    // Quan hệ với bảng user_voucher
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_voucher');
    }

    // Tính số lượt sử dụng
    public function getUsageCountAttribute()
    {
        return $this->userVouchers()->where('is_used', 1)->count();
    }

    // Tự động hiển thị trangjt hái hết hạn khi end_date đã qua
    public function getStatusAttribute($value)
{
    if (Carbon::now()->greaterThan($this->end_date)) {
        return 0; // Hết hạn
    }
    return $value; // Giữ nguyên trạng thái cũ nếu chưa hết hạn
}



    public function applyVoucher($voucherCode)
    {
        $voucher = Voucher::where('code', $voucherCode)->where('status', 'active')->first();

        if (!$voucher) {
            return ['success' => false, 'message' => 'Voucher không hợp lệ hoặc đã hết hạn.'];
        }

        // Lấy tổng tiền giỏ hàng (giả sử đã có method getCartTotal)
        $cartTotal = $this->calculateCartTotal();

        if ($voucher->min_order_value && $cartTotal < $voucher->min_order_value) {
            return ['success' => false, 'message' => 'Đơn hàng chưa đạt mức tối thiểu để áp dụng voucher.'];
        }

        $discountAmount = 0;

        if ($voucher->discount_type === 'percentage') {
            // Tính số tiền giảm giá theo %
            $discountAmount = ($cartTotal * $voucher->discount_value) / 100;
            // Nếu có giới hạn giảm tối đa thì áp dụng
            if ($voucher->max_discount) {
                $discountAmount = min($discountAmount, $voucher->max_discount);
            }
        } else {
            // Giảm giá cố định
            $discountAmount = $voucher->discount_value;
        }

        // Cập nhật tổng tiền sau khi áp dụng giảm giá
        $this->total_price = max(0, $cartTotal - $discountAmount);
        $this->discount_amount = $discountAmount;
        $this->id_voucher = $voucher->id;
        $this->save();

        return ['success' => true, 'message' => 'Áp dụng voucher thành công!', 'discount' => $discountAmount];
    }

    private function calculateCartTotal()
    {
        return $this->order_items()->sum('subtotal'); // Giả sử đã có quan hệ order_items()
    }
}
