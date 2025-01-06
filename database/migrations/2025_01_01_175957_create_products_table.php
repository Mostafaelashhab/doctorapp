<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->longText('description');
            $table->string('price');
            $table->string('quantity')->nullable();
            $table->boolean('is_stock')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->bigInteger('bedrooms')->nullable();
            $table->bigInteger('bathrooms')->nullable();
            $table->bigInteger('area')->nullable();
            $table->enum('type', ['rent', 'sale'])->default('sale');
            $table->enum('type_proudct', ['product', 'apartment'])->default('product');
            $table->boolean('is_pay')->default(true);
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
