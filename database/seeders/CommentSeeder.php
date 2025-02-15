<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = \App\Models\User::pluck('id')->toArray(); // Lấy tất cả các id_user từ bảng users
        $products = \App\Models\Product::pluck('id')->toArray(); // Lấy tất cả các id_product từ bảng products

        // Chèn 20 bình luận ngẫu nhiên
        for ($i = 0; $i < 20; $i++) {
            DB::table('comments')->insert([
                'id_user' => $faker->randomElement($users), // Chọn ngẫu nhiên id_user
                'id_product' => $faker->randomElement($products), // Chọn ngẫu nhiên id_product
                'note' => $faker->sentence(), // Nội dung bình luận ngẫu nhiên
                'created_at' => $faker->dateTimeThisYear(), // Thời gian tạo ngẫu nhiên trong năm nay
            ]);
        }
    }
}
