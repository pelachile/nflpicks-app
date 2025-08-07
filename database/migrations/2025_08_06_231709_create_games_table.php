<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('espn_id')->unique();
            $table->integer('week');
            $table->integer('season');
            $table->timestamp('date_time');
            $table->foreignId('venue_id')->constrained();
            $table->string('status')->default('scheduled');
            $table->json('weather_conditions')->nullable();
            $table->timestamps();

            // Index for common queries
            $table->index(['season', 'week']);
            $table->index('date_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
