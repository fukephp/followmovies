<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use \Cviebrock\EloquentSluggable\Services\SlugService;

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
        $title = $this->faker->jobTitle();
        $slug = SlugService::createSlug(Movie::class, 'slug', $title);

        return [
            'title' => $title,
            'slug' => $slug,
            'caption' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'rating' => $this->faker->randomFloat(1, 1.0, 10.0),
            'vote_count' => $this->faker->randomNumber(),
            'released_at' => $this->faker->date('Y-m-d')
        ];
    }
}
