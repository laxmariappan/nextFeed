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
        Schema::create('feeding_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['breast_left', 'breast_right', 'bottle', 'formula'])->default('breast_left');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('quantity_ml')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_logs');
    }
};
