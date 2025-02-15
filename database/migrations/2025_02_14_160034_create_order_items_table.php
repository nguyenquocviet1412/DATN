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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order')->nullable();
            $table->unsignedBigInteger('id_variant')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            // Quan hệ với bảng orders và variants
            $table->foreign('id_order')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('id_variant')->references('id')->on('variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
