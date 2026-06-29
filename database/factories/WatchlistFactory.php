<?php

namespace Database\Factories;

use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Watchlist>
 */
class WatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'tmdb_movie_id' => fake()->unique()->numberBetween(1, 100000),
            'title' => fake()->sentence(3),
            'poster_path' => '/'.fake()->uuid().'.jpg',
            'type' => fake()->randomElement(['movie', 'tv']),
            'is_watched' => false,
        ];
    }

    public function watched(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_watched' => true,
        ]);
    }
}
