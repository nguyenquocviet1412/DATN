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
            $table->string('title')->nullable();       // Tiêu đề banner (nếu có)
            $table->string('image');                     // Đường dẫn ảnh banner
            $table->text('description')->nullable();     // Mô tả banner (nếu có)
            $table->string('type')->nullable();          // Loại banner
            $table->boolean('status')->default(1);       // 1: Hiển thị, 0: Ẩn
            $table->softDeletes();                       // Thêm cột deleted_at để hỗ trợ xóa mềm
            $table->timestamps();                        // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
}
