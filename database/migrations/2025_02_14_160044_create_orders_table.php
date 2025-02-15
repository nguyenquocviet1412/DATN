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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_voucher')->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->integer('user_points')->default(0)->nullable();
            $table->integer('points_earned')->default(0);
            $table->string('shipping_address');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();

            // Quan hệ với bảng users và vouchers
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
