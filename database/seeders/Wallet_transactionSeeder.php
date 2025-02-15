<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class Wallet_transactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách tất cả id_wallet
        $walletIds = DB::table('wallets')->pluck('id');

        foreach ($walletIds as $walletId) {
            // Giả sử số dư ban đầu của ví là từ 500,000 - 5,000,000 VND
            $balanceBefore = rand(500, 5000) * 1000;
            $amount = rand(100, 1000) * 1000; // Giao dịch từ 100,000 đến 1,000,000 VND
            $transactionType = $faker->randomElement(['deposit', 'withdrawal', 'purchase', 'refund']);
            $balanceAfter = ($transactionType === 'withdrawal' || $transactionType === 'purchase')
                ? $balanceBefore - $amount
                : $balanceBefore + $amount;

            DB::table('wallet_transactions')->insert([
                'id_wallet' => $walletId,
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => max($balanceAfter, 0), // Không để số dư âm
                'description' => $faker->sentence(),
                'status' => 'completed',
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
