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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_product')->nullable();
            $table->unsignedBigInteger('id_order_item')->nullable();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null'); // Liên kết với bảng users
            $table->foreign('id_product')->references('id')->on('products')->onDelete('set null'); // Liên kết với bảng products
            $table->foreign('id_order_item')->references('id')->on('order_items')->onDelete('set null'); // Liên kết với bảng order_items
            $table->tinyInteger('rating')->unsigned()->check('rating >= 1 AND rating <= 5'); // Đánh giá từ 1-5
            $table->text('review')->nullable(); // Nội dung đánh giá
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái duyệt đánh giá
            $table->timestamps();
            // Ràng buộc duy nhất: 1 người chỉ đánh giá 1 lần cho 1 sản phẩm trong đơn hàng
            $table->unique(['id_user', 'id_product', 'id_order_item']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
