<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'fullname' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('123456'), // Mật khẩu mặc định
                'phone' => $faker->unique()->phoneNumber(),
                'address' => $faker->address(),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'role' => 'user',
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(rand(0, 365)), // Random từ 0 đến 365 ngày trước
            ]);
        }
    }
}
