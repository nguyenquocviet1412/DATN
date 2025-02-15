<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class Product_imageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $variants = \App\Models\Variant::pluck('id')->toArray(); // Lấy danh sách id_variant

        foreach ($variants as $variant) {
            // Mỗi biến thể sẽ có từ 1 đến 3 ảnh
            $numImages = rand(1, 3);
            for ($i = 0; $i < $numImages; $i++) {
                DB::table('product_images')->insert([
                    'id_variant' => $variant,
                    'image_url' => $faker->imageUrl(400, 400, 'fashion'), // Đường dẫn ảnh ngẫu nhiên
                    'is_primary' => $i === 0 ? true : false, // Ảnh đầu tiên sẽ là ảnh chính
                    'created_at' => $faker->dateTimeThisYear(),
                ]);
            }
        }
    }
}
