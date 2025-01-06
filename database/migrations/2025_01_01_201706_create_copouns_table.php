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
        Schema::create('copouns', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('discount');
            $table->enum('type', ['percentage', 'fixed']);
            $table->bigInteger('limit_usage_user')->default(1);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copouns');
    }
};
