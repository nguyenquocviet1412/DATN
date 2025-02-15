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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_category')->nullable(); // Mã danh mục sản phẩm
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('set null'); // Liên kết với bảng categories
            $table->bigInteger('price'); // Giá sản phẩm (VND)
            $table->integer('view')->default(0); // Lượt xem sản phẩm
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái sản phẩm
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
