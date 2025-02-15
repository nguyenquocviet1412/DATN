<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('carts')->insert([
                'id_user' => rand(1, 10), // Giả sử có 10 user
                'id_variant' => rand(1, 50), // Giả sử có 50 sản phẩm biến thể
                'quantity' => rand(1, 5),
                'price' => rand(100000, 2000000), // Giá từ 100k đến 2 triệu
                'created_at' => Carbon::now()->subDays(rand(0, 365)), // Random từ 0 đến 365 ngày trước
            ]);
        }
    }
}
