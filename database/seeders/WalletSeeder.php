<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách tất cả user_id
        $userIds = DB::table('users')->pluck('id');

        foreach ($userIds as $userId) {
            DB::table('wallets')->insert([
                'id_user' => $userId,
                'balance' => rand(100, 10000) * 1000, // Ngẫu nhiên từ 100k đến 10 triệu VND
                'currency' => 'VND',
                'status' => 'active',
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
