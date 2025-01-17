<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anime>
 */
class AnimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anime_name = $this->faker->unique()->name();

        return [
            'specs' => 1,
            'user_id' => 1,
            'name' => $anime_name,
            'slug' => Str::slug($anime_name),
            'release_date' => $this->faker->date(),
            'imdb_score' => 8.5,
            'summary' => $this->faker->text(),
        ];
    }
}
