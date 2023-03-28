<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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

    public function createToken(User $user)
    {
        return auth()->login($user);
    }
}
