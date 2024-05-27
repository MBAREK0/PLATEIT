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
        Schema::create('restaurant_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('category_id')->default(1)->constrained('categories')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('address')->nullable();
            $table->string('phone_numbre')->nullable();
            $table->string('web_site')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_details');
    }
};
