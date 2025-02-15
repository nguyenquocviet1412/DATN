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
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable(); // ID người dùng, có thể null nếu người dùng đã bị xóa hoặc không tồn tại
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->integer('points')->default(0); // Điểm thưởng của người dùng, mặc định là 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
