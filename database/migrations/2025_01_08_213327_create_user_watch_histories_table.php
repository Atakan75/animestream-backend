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
        Schema::create('user_watch_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('specs');
            $table->integer('user_id');
            $table->integer('anime_id');
            $table->integer('episode_id');
            $table->timestamp('watched_at');
            $table->time('duration_watched')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_watch_histories');
    }
};
