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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_variant')->nullable(); // Khóa chính liên kết với bảng variants, để cho phép nhiều ảnh sản phẩm có thể liên kết đến cùng một biến thể
            $table->foreign('id_variant')->references('id')->on('variants')->onDelete('set null'); // Khóa ngoại liên kết với bảng variants
            $table->string('image_url'); // Đường dẫn ảnh sản phẩm
            $table->boolean('is_primary')->default(false); // Ảnh đại diện chính của biến thể
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
