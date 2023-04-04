<?php

namespace Tests\Feature;

use App\Enums\ApiPrefix;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JustSteveKing\StatusCode\Http;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserSeeFavoriteMovies()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();
        $user->movies()->attach($movie->id);

        $response = $this->actingAs($user)->getJson(ApiPrefix::USER_API_PREFIX() . '/favorite-movies');

        $response->assertJsonCount($user->movies()->count(), 'data.favorite_movies')
            ->assertStatus(Http::OK());
    }

    public function testCanUserFollowMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->postJson(ApiPrefix::USER_API_PREFIX() . '/' . $movie->slug . '/follow');

        $response->assertStatus(Http::OK());
    }
}
