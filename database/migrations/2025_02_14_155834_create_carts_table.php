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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user')->nullable(); // Tham chiếu đến id của bảng users
            $table->unsignedBigInteger('id_variant')->nullable(); // Tham chiếu đến id của bảng product_variants // Sản phẩm biến thể (size, màu)

            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null'); // Liên kết với users //xóa dữ liệu bảng cha thì dữ liệu trong bảng con sẽ là null
            $table->foreign('id_variant')->references('id')->on('variants')->onDelete('set null'); // Sản phẩm biến thể (size, màu)
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Giá của sản phẩm tại thời điểm thêm vào giỏ hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
