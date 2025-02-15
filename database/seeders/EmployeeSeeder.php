<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Dùng locale tiếng Việt

        for ($i = 0; $i < 20; $i++) {
            DB::table('employees')->insert([
                'username' => $faker->unique()->userName(),
                'password' => Hash::make('123456'),
                'role' => $faker->randomElement(['admin', 'staff']),
                'fullname' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->unique()->phoneNumber(),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'date_of_birth' => $faker->date(),
                'address' => $faker->address(),
                'position' => $faker->jobTitle(),
                'salary' => $faker->numberBetween(5000000, 30000000), // Lương từ 5 triệu đến 30 triệu VND
                'status' => 'active',
                'created_at' => $faker->dateTimeThisYear(), // Thời gian tạo ngẫu nhiên trong năm nay
            ]);
        }
    }
}
