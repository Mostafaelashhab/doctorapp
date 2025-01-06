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
        Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('code')->nullable();
                $table->string('referal_code')->default(rand('100000', '999999'));
                $table->string('name');
                $table->string('email')->nullable()->unique();
                $table->string('phone')->nullable()->unique();
                $table->string('address')->nullable();
                $table->string('height')->nullable();
                $table->string('device_token')->nullable();
                $table->string('provider_id')->nullable();
                $table->enum('provider', ['google', 'facebook'])->nullable();
                $table->string('weight')->nullable();
                $table->string('status')->nullable();
                $table->string('health_goal')->nullable();
                $table->string('blood_type')->nullable();
                $table->enum('gender', ['male', 'female'])->nullable();
                $table->string('age')->nullable();
                $table->string('birth_day')->nullable();
                $table->bigInteger('point_booking')->default(500);
                $table->bigInteger('point_refaral')->default(0);
                $table->bigInteger('wallet_balance')->default(0);
                $table->bigInteger('point_shop')->default(0);//point for shop 50 
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
