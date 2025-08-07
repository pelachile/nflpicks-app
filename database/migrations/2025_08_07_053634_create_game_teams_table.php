<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained();
            $table->boolean('is_home');
            $table->integer('score')->default(0);
            $table->timestamps();

            // Ensure each team appears only once per game
            $table->unique(['game_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_teams');
    }
};
