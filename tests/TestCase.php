<?php

namespace Tests;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser(array $attributes = []): User
    {
        $user = User::factory()->create($attributes);

        return $user;
    }

    public function createUserRaw(array $attributes = []): array
    {
        return User::factory()->raw($attributes);
    }

    public function createMovie(array $attributes = []): Movie
    {
        return Movie::factory()->create($attributes);
    }

    public function createMovieRaw(array $attributes = []): array
    {
        return Movie::factory()->raw($attributes);
    }

    public function createToken(User $user)
    {
        return auth()->login($user);
    }

    public function hasAllAssertJson($response, array $attributes = [])
    {
        return $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll($attributes)
        );
    }
}
