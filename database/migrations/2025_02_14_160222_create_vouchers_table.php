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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá duy nhất
            $table->enum('discount_type', ['percentage', 'fixed']); // Kiểu giảm giá: % hoặc số tiền cố định
            $table->integer('discount_value'); // Giá trị giảm giá (nếu là percentage thì lưu 10, 20, 50...)
            $table->integer('min_order_value')->nullable(); // Giá trị đơn hàng tối thiểu (VND)
            $table->integer('max_discount')->nullable(); // Giới hạn mức giảm tối đa (VND) nếu là %
            $table->dateTime('start_date'); // Ngày bắt đầu
            $table->dateTime('end_date'); // Ngày kết thúc
            $table->integer('usage_limit')->default(1); // Giới hạn số lần sử dụng
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->enum('status', ['active', 'expired', 'disabled'])->default('active'); // Trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
