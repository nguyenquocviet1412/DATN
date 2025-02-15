<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = \App\Models\User::pluck('id')->toArray(); // Lấy tất cả các id_user từ bảng users
        $vouchers = \App\Models\Voucher::pluck('id')->toArray(); // Lấy tất cả các id_voucher từ bảng vouchers

        // Chèn 20 đơn hàng ngẫu nhiên
        for ($i = 0; $i < 20; $i++) {
            $userId = $faker->randomElement($users); // Chọn ngẫu nhiên id_user
            $voucherId = $faker->randomElement($vouchers); // Chọn ngẫu nhiên id_voucher

            // Lấy số điểm người dùng có
            $userPoints = \App\Models\User::find($userId)->points;

            // Lấy tất cả các sản phẩm trong order_items cho đơn hàng này (bạn cần có order_item đã tồn tại)
            // Tạo ID cho đơn hàng mới
            $orderId = DB::table('orders')->insertGetId([
                'id_user' => $userId,
                'id_voucher' => $voucherId,
                'discount_amount' => 0, // Tạm thời để 0, bạn có thể tính lại sau khi áp dụng voucher
                'total_price' => 0, // Tạm thời để 0, sẽ tính sau
                'user_points' => $userPoints,
                'points_earned' => 0, // Bạn có thể tính lại sau
                'shipping_address' => $faker->address,
                'payment_status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'created_at' => $faker->dateTimeThisYear(),
            ]);

            // Tính tổng giá trị đơn hàng từ các sản phẩm trong bảng order_items
            $orderItems = DB::table('order_items')->where('id_order', $orderId)->get();

            $totalPrice = 0;
            foreach ($orderItems as $item) {
                $variant = \App\Models\Variant::find($item->id_variant);
                $totalPrice += $variant->price * $item->quantity;
            }

            // Tính lại discount_amount và final price nếu có phiếu giảm giá
            $discountAmount = $voucherId ? rand(5, 30) / 100 * $totalPrice : 0;
            $finalPrice = $totalPrice - $discountAmount;

            // Cập nhật lại thông tin đơn hàng
            DB::table('orders')->where('id', $orderId)->update([
                'discount_amount' => $discountAmount,
                'total_price' => $finalPrice,
                'points_earned' => floor($finalPrice / 1000),
            ]);
        }

    }
}
