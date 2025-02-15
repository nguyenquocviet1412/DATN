<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class User_voucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = DB::table('users')->pluck('id'); // Lấy danh sách ID user
        $vouchers = DB::table('vouchers')->pluck('id'); // Lấy danh sách ID voucher

        foreach ($users as $userId) {
            for ($i = 0; $i < 2; $i++) { // Mỗi user có thể có 2 voucher ngẫu nhiên
                DB::table('user_vouchers')->insert([
                    'id_user' => $userId,
                    'id_voucher' => $vouchers->random(),
                    'is_used' => (rand(0, 1) == 1), // Ngẫu nhiên đã dùng hoặc chưa
                    'created_at' => $faker->dateTimeThisYear,
                ]);
            }
        }
    }
}
