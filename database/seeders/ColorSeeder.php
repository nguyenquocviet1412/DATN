<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Black', 'White', 'Green'];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'name' => $color,
                'created_at' => Carbon::now()->subDays(rand(0, 365)), // Random từ 0 đến 365 ngày trước
            ]);
        }
    }
}
