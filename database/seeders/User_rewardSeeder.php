<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class User_rewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = DB::table('users')->pluck('id'); // Lấy danh sách ID người dùng

        foreach ($users as $userId) {
            DB::table('user_rewards')->insert([
                'id_user' => $userId,
                'points' => rand(0, 50000), // Ngẫu nhiên từ 0 đến 50000 điểm
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
