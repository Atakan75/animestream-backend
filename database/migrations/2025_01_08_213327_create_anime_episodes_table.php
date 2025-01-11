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
        Schema::create('anime_episodes', function (Blueprint $table) {
            $table->id();
            $table->integer('specs');
            $table->integer('anime_id');
            $table->integer('season_id');
            $table->string('name');
            $table->string('slug');
            $table->text('summary');
            $table->time('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_episodes');
    }
};
