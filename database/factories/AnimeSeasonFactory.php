<?php

namespace Database\Factories;

use App\Models\Anime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnimeSeason>
 */
class AnimeSeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anime_season_name = $this->faker->unique()->name();

        return [
            'specs' => 1,
            'anime_id' => Anime::factory(),
            'name' => $anime_season_name,
        ];
    }
}
