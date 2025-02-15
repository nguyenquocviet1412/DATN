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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_wallet')->nullable(); // ID ví, NULL nếu giao dịch không liên quan đến ví nào
            $table->foreign('id_wallet')->references('id')->on('wallets')->onDelete('set null'); // Liên kết với ví
            $table->enum('transaction_type', ['deposit', 'withdrawal', 'purchase', 'refund'])->default('deposit'); // Loại giao dịch
            $table->decimal('amount', 15, 2); // Số tiền giao dịch
            $table->decimal('balance_before', 15, 2); // Số dư trước giao dịch
            $table->decimal('balance_after', 15, 2); // Số dư sau giao dịch
            $table->string('description')->nullable(); // Mô tả giao dịch
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed'); // Trạng thái giao dịch
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
