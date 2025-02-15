<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Faker\Factory as Faker;
class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) { // Tạo 10 voucher ngẫu nhiên
            $discountType = rand(0, 1) ? 'percentage' : 'fixed'; // Loại giảm giá: % hoặc số tiền
            $discountValue = ($discountType === 'percentage')
                ? rand(5, 50)  // Nếu là %, giảm từ 5% đến 50%
                : rand(50, 500) * 1000; // Nếu là tiền, giảm từ 50,000 đến 500,000 VND

            $minOrderValue = rand(500, 2000) * 1000; // Đơn hàng tối thiểu từ 500,000 - 2,000,000 VND
            $maxDiscount = ($discountType === 'percentage') ? rand(100, 500) * 1000 : null; // Giới hạn tối đa nếu là %

            $startDate = $faker->dateTimeThisYear();
            $endDate = now()->addDays(rand(10, 30))->format('Y-m-d H:i:s'); // Hạn dùng 10-30 ngày

            DB::table('vouchers')->insert([
                'code' => strtoupper(Str::random(8)), // Mã voucher ngẫu nhiên
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'min_order_value' => $minOrderValue,
                'max_discount' => $maxDiscount,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'usage_limit' => rand(1, 3), // Giới hạn 1-3 lần
                'used_count' => 0, // Chưa dùng
                'status' => 'active',
                'created_at' => $startDate,
                'updated_at' => now(),
            ]);
        }
    }
}
