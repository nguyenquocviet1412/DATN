<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $sizes = ['35','36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];

        foreach ($sizes as $size) {
            DB::table('sizes')->insert([
                'size' => $size,
                'created_at' => $faker->dateTimeThisYear()
            ]);
        }
    }
}
