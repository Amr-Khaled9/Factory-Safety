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
        Schema::create('fire_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['fire', 'smoke', 'other']);
            $table->float('confidence');
            $table->string('image')->nullable();
            $table->string('number_camera')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_logs');
    }
};
