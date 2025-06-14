<?php

namespace Database\Factories;

use App\Models\Anime;
use App\Models\AnimeSeason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnimeEpisode>
 */
class AnimeEpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anime_episode_name = $this->faker->unique()->name();

        return [
            'specs' => 1,
            'video_id' => 1,
            'anime_id' => Anime::factory(),
            'season_id' => AnimeSeason::factory(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'summary' => $this->faker->text(),
            'duration' => '10:20:30',
        ];
    }
}
