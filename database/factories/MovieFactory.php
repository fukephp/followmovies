<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'First title',
            'slug' => 'First-title-movie',
            'caption' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'rating' => $this->faker->randomFloat(1, 1.0, 10.0),
            'vote_count' => $this->faker->randomNumber(),
            'released_at' => $this->faker->date('Y-m-d')
        ];
    }
}
