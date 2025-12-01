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
        Schema::create('abnormalbehavior_logs', function (Blueprint $table) {
            $table->id();
            $table->string('behavior_type');
            $table->string('image');
            $table->foreignId('camera_id')->constrained('cameras')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abnormalbehavior_logs');
    }
};
