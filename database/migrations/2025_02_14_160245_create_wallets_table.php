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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable(); // Trư��ng liên kết với bảng users, nullable để cho phép null ở trư��ng này
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null'); // Ràng buộc với bảng users
            $table->decimal('balance', 15, 2)->default(0); // Số dư, mặc định là 0 VND
            $table->string('currency', 10)->default('VND'); // Đơn vị tiền tệ (VNĐ)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái ví
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
