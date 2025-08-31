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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->onDelete('cascade');
            $table->string('withdrawal_id')->nullable();
            $table->enum('method', ['bank', 'upi', 'binance'])->default('bank');
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->enum('status', ['pending', 'inprogress', 'success', 'canceled', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
