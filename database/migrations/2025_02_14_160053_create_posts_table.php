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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_employee')->nullable(); // Khóa ngoại liên kết với bảng employees, null cho phép bài viết không có người viết
            $table->foreign('id_employee')->references('id')->on('employees')->onDelete('set null'); // Khóa ngoại liên kết với bảng employees
            $table->string('title'); // Tiêu đề bài viết
            $table->text('content'); // Nội dung bài viết
            $table->string('image')->nullable(); // Ảnh bài viết (có thể null)
            $table->enum('status', ['draft', 'published'])->default('draft'); // Trạng thái bài viết
            $table->timestamps(); // created_at và updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
