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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product')->nullable();
            $table->unsignedBigInteger('id_color')->nullable();
            $table->unsignedBigInteger('id_size')->nullable();
            $table->foreign('id_product')->references('id')->on('products')->onDelete('set null');
            $table->foreign('id_color')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('id_size')->references('id')->on('sizes')->onDelete('set null');
            $table->integer('price'); // Giá tiền (VND)
            $table->integer('quantity')->default(0); // Số lượng tồn kho
            $table->enum('status', ['available', 'out_of_stock'])->default('available'); // Trạng thái sản phẩm
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
