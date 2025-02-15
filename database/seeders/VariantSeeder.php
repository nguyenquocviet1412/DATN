<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $products = DB::table('products')->pluck('id'); // Lấy danh sách ID sản phẩm
        $colors = DB::table('colors')->pluck('id'); // Lấy danh sách ID màu sắc
        $sizes = DB::table('sizes')->pluck('id'); // Lấy danh sách ID size

        foreach ($products as $productId) {
            for ($i = 0; $i < 3; $i++) { // Mỗi sản phẩm có 3 biến thể ngẫu nhiên
                DB::table('variants')->insert([
                    'id_product' => $productId,
                    'id_color' => $colors->random(),
                    'id_size' => $sizes->random(),
                    'price' => rand(100, 2000) * 1000, // Giá từ 100,000 - 2,000,000 VND
                    'quantity' => rand(1, 50),
                    'status' => 'available',
                    'created_at' => $faker->dateTimeThisYear(),
                ]);
            }
        }
    }
}
