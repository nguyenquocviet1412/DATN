<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Khóa chính tự tăng
            $table->string('fullname'); // Họ tên
            $table->string('email')->unique(); // Email duy nhất
            $table->string('password'); // Mật khẩu
            $table->string('phone')->unique(); // Số điện thoại duy nhất
            $table->string('address'); // Địa chỉ
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable(); // Giới tính
            $table->enum('role', ['admin', 'user'])->default('user'); // Phân quyền
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái tài khoản
            $table->rememberToken(); // Token để ghi nhớ đăng nhập
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
