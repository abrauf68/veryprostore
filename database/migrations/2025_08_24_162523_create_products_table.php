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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('vendor_id')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('sku')->unique();
            $table->text('short_description');
            $table->text('description');
            $table->string('main_image')->nullable();
            $table->foreignId('category_id')->nullable()
                ->constrained('product_categories')
                ->nullOnDelete();
            $table->string('cost_price')->default('0');
            $table->string('price')->default('0');
            $table->string('profit')->default('0');
            $table->string('discount')->default('0');
            $table->string('stock')->default('0');
            $table->enum('is_active', ['active', 'inactive'])->default('active');
            $table->enum('is_popular', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
