<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = \App\Models\User::pluck('id')->toArray();
        $products = \App\Models\Product::pluck('id')->toArray();
        $orderItems = \App\Models\Order_item::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) { // Tạo 50 đánh giá ngẫu nhiên
            DB::table('rates')->insert([
                'id_user' => $faker->randomElement($users),
                'id_product' => $faker->randomElement($products),
                'id_order_item' => $faker->randomElement($orderItems),
                'rating' => rand(1, 5), // Chấm điểm từ 1-5
                'review' => $faker->sentence(10), // Bình luận ngẫu nhiên
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']), // Trạng thái
                'created_at' => $faker->dateTimeThisYear()
            ]);
        }
    }
}
