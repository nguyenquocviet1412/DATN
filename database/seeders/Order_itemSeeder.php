<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class Order_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $orders = \App\Models\Order::pluck('id')->toArray(); // Lấy tất cả các id_order từ bảng orders
        $variants = \App\Models\Variant::pluck('id')->toArray(); // Lấy tất cả các id_variant từ bảng variants

        // Chèn 20 mục order item ngẫu nhiên
        for ($i = 0; $i < 20; $i++) {
            $variantId = $faker->randomElement($variants); // Chọn ngẫu nhiên id_variant
            $variant = \App\Models\Variant::find($variantId); // Tìm variant tương ứng

            // Giá từ variant
            $price = $variant->price;

            $subtotal = $price * $faker->numberBetween(1, 5); // Thành tiền = giá * số lượng

            DB::table('order_items')->insert([
                'id_order' => $faker->randomElement($orders), // Chọn ngẫu nhiên id_order
                'id_variant' => $variantId, // Chọn ngẫu nhiên id_variant
                'quantity' => $faker->numberBetween(1, 5), // Số lượng ngẫu nhiên từ 1 đến 5
                'price' => $price, // Lấy giá từ variant
                'subtotal' => $subtotal, // Thành tiền ngẫu nhiên
                'created_at' => $faker->dateTimeThisYear(), // Thời gian tạo ngẫu nhiên trong năm nay
                'updated_at' => now(),
            ]);
        }
    }
}
