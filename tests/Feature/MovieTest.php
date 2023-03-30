<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserSeeAllMovieList()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $this->createMovies(5);

        $response = $this->actingAs($user)->getJson('/api/movies');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 5)
                ->has('links')
                ->has('meta'))
            ->assertStatus(Http::OK());
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
            'slug' => 'movie-example'
        ]);

        $response = $this->actingAs($user)->postJson('/api/movies', $data);

        $response->assertStatus(Http::CREATED());
    }

    public function testCanUserUpdateMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $data = $this->createMovieRaw([
            'title' => 'Movie example update',
            'slug' => 'movie-example-update'
        ]);

        $response = $this->actingAs($user)->putJson('/api/movies/'.$movie->slug, $data);

        $response->assertStatus(Http::ACCEPTED());
    }

    public function testCanUserDeleteMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->deleteJson('/api/movies/'.$movie->slug);

        $response->assertStatus(Http::NO_CONTENT());
    }
}
