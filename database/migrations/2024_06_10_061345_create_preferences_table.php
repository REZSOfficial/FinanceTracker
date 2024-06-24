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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->smallInteger('food_and_drink')->default('0');
            $table->smallInteger('housing')->default('1');
            $table->smallInteger('transportation')->default('2');
            $table->smallInteger('healthcare')->default('3');
            $table->smallInteger('entertainment')->default('4');
            $table->smallInteger('other')->default('5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
