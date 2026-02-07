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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key to users table (The user who created the report)
            $table->foreignId('worker_id')->nullable()->constrained()->onDelete('set null'); // Foreign Key to workers table (The worker involved, if any)
            $table->foreignId('camera_id')->nullable()->constrained()->onDelete('set null'); // Foreign Key to cameras table (The camera that captured the event, if any)
            $table->string('report_type');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
