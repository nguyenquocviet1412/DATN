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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Tiêu đề banner (nếu có)
            $table->string('image'); // Đường dẫn ảnh banner
            $table->text('description')->nullable();// Mô tả banner (nếu có)
            $table->string('type')->nullable(); // loại banner
            $table->boolean('status')->default('active'); // Trạng thái (hiển thị hoặc không)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
