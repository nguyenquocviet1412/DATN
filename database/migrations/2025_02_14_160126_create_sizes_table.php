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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size')->unique()->change(); // Đảm bảo mỗi size là duy nhất
            $table->timestamps();
            $table->softDeletes(); // Xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
