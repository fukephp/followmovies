<?php

namespace Tests\Feature;

use App\Enums\ApiPrefix;
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

        $response = $this->actingAs($user)->getJson(ApiPrefix::MOVIE_API_PREFIX());

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

        $response = $this->actingAs($user)->getJson(ApiPrefix::MOVIE_API_PREFIX() . '/' . $movie->slug);

        $response->assertStatus(Http::OK())
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'slug',
                    'title',
                    'caption',
                    'image_url',
                    'rating',
                    'vote_count',
                    'released_at',
                    'created_at',
                    'updated_at',
                    'users',
                    'follow_users_count'
                ],
                'success'
            ]);
    }

    public function testCanUserStoreMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $data = $this->createMovieRaw([
            'title' => 'Movie example',
            'slug' => 'movie-example'
        ]);

        $response = $this->actingAs($user)->postJson(ApiPrefix::MOVIE_API_PREFIX(), $data);

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

        $response = $this->actingAs($user)->putJson(ApiPrefix::MOVIE_API_PREFIX() . '/' . $movie->slug, $data);

        $response->assertStatus(Http::ACCEPTED());
    }

    public function testCanUserDeleteMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->deleteJson(ApiPrefix::MOVIE_API_PREFIX() . '/' . $movie->slug);

        $response->assertStatus(Http::OK());
    }

    public function testCanUserSeeValidationErrorsStoreMovie()
    {
        $user = $this->createUser();

        $data = $this->createMovieRaw([
            'title' => ''
        ]);

        $response = $this->actingAs($user)->postJson(ApiPrefix::MOVIE_API_PREFIX(), $data);

        $response->assertStatus(Http::UNPROCESSABLE_ENTITY())
            ->assertJson(function (AssertableJson $json) use ($data) {
                $json->has('message')
                    ->has('errors', 1) // it will check the exact size of the errors bag
                    ->whereAllType([
                        'errors.title' => 'array',
                    ]);
            });
    }

    public function testCanUserSeeValidationErrorsUpdateMovie()
    {
        $user = $this->createUser();
        $movie = $this->createMovie();

        $data = $this->createMovieRaw([
            'title' => ''
        ]);

        $response = $this->actingAs($user)->putJson(ApiPrefix::MOVIE_API_PREFIX() . '/' . $movie->slug, $data);

        $response->assertStatus(Http::UNPROCESSABLE_ENTITY())
            ->assertJson(function (AssertableJson $json) use ($data) {
                $json->has('message')
                    ->has('errors', 1) // it will check the exact size of the errors bag
                    ->whereAllType([
                        'errors.title' => 'array',
                    ]);
            });
    }
}
