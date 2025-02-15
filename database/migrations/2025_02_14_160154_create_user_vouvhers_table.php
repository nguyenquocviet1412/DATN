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
        Schema::create('user_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_voucher')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('set null');
            $table->boolean('is_used')->default(false); // Xác định voucher đã được sử dụng hay chưa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vouvhers');
    }
};
