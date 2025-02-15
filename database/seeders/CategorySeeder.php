<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Sneakers', 'Boots', 'Casual Shoes', 'Formal Shoes', 'Running Shoes'];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => Carbon::now()->subDays(rand(0, 365)), // Random từ 0 đến 365 ngày trước
            ]);
        }
    }
}
