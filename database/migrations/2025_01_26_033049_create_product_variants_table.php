<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sku', 100)->nullable(true)->unique();
            $table->integer('stock')->nullable(false)->default(0);
            $table->decimal('price', 14, 2)->nullable(false);
            $table->foreignUuid('product_id')->nullable(false)->constrained('products');
            $table->foreignUuid('category_id')->nullable(false)->constrained('categories');
            $table->foreignUuid('size_id')->nullable(false)->constrained('sizes');
            $table->foreignUuid('color_id')->nullable(false)->constrained('colors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
