<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserSeeAllMovieList()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $response = $this->actingAs($user)->getJson('/api/movies');

        $response->assertStatus(Http::OK());
    }

    public function testCanUserSeeSingleMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->getJson('/api/movies/'.$movie->slug);

        $response->assertStatus(Http::OK());
    }

    public function testCanUserStoreMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $data = $this->createMovieRaw([
            'title' => 'Movie example',
            'slug' => 'movie-example-movie'
        ]);

        $response = $this->actingAs($user)->postJson('/api/movies', $data);

        $response->assertStatus(Http::CREATED());
    }
}
