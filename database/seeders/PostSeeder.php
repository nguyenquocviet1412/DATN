<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $employees = \App\Models\Employee::pluck('id')->toArray(); // Lấy danh sách ID nhân viên

        for ($i = 0; $i < 20; $i++) {
            DB::table('posts')->insert([
                'id_employee' => $faker->randomElement($employees), // Chọn ngẫu nhiên một nhân viên
                'title' => $faker->sentence(6), // Tiêu đề ngẫu nhiên
                'content' => $faker->paragraphs(3, true), // Nội dung bài viết
                'image' => $faker->imageUrl(640, 480, 'business', true, 'Faker'), // Ảnh bài viết giả lập
                'status' => $faker->randomElement(['draft', 'published']), // Trạng thái bài viết
                'created_at' => $faker->dateTimeThisYear(), // Ngày tạo ngẫu nhiên trong năm nay
                'updated_at' => now(),
            ]);
        }
    }
}
