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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->unsignedBigInteger('id_user')->nullable(); // Khóa ngoại liên kết với bảng users
            $table->unsignedBigInteger('id_product')->nullable(); // Khóa ngoại liên kết với bảng products
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null'); // Liên kết với bảng users
            $table->foreign('id_product')->references('id')->on('products')->onDelete('set null'); // Liên kết với bảng products
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
