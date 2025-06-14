<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\AnimeEpisode;
use App\Models\AnimeSeason;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Anime::factory(10)->create();
        AnimeEpisode::factory(10)->create();
        AnimeSeason::factory(10)->create();
    }
}
