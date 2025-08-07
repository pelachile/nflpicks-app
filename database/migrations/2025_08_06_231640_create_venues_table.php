<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('espn_id')->unique()->nullable();
            $table->string('name');
            $table->string('city');
            $table->string('state');
            $table->integer('capacity')->nullable();
            $table->boolean('dome')->nullable();
            $table->string('surface_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
