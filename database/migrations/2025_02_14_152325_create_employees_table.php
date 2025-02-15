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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff'])->default('staff'); // Quyền của nhân viên
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('position'); // Chức vụ (VD: Nhân viên bán hàng, Quản lý)
            $table->decimal('salary', 10, 2); // Lương mặc định là VND
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái
            $table->rememberToken(); // Lưu token đăng nhập
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
