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
        Schema::create('auto_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id')->unique();
            $table->unsignedBigInteger('make_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('make_id')->references('make_id')->on('auto_makes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_models');
    }
};
