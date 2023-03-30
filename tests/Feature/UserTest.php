<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JustSteveKing\StatusCode\Http;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserFollowMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->postJson("/api/user/movies/{$movie->slug}/follow");

        $response->assertStatus(Http::OK());
    }

    public function testCanUserUnfollowMovie()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $movie = $this->createMovie();

        $response = $this->actingAs($user)->postJson("/api/user/movies/{$movie->slug}/unfollow");

        $response->assertStatus(Http::NO_CONTENT());
    }
}
