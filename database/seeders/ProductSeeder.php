<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = \App\Models\Category::pluck('id')->toArray(); // Lấy danh sách id_category

        for ($i = 0; $i < 20; $i++) {
            DB::table('products')->insert([
                'name' => $faker->word() . ' Shoes', // Tên ngẫu nhiên
                'description' => $faker->paragraph(3), // Mô tả sản phẩm
                'id_category' => $faker->randomElement($categories), // Chọn ngẫu nhiên danh mục
                'price' => rand(100, 2000) * 1000, // Giá từ 100k đến 2 triệu (chẵn nghìn)
                'view' => rand(0, 1000), // Lượt xem ngẫu nhiên
                'status' => $faker->randomElement(['active', 'inactive']), // Trạng thái
                'created_at' => $faker->dateTimeThisYear(), // Ngày tạo ngẫu nhiên trong năm nay
            ]);
        }
    }
}
