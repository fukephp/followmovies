<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserLogin(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->actingAs($user)->postJson('/api/login', $data);

        $this->hasAllAssertJson($response, ['token', 'expires_in', 'token_type']);
        $response->assertStatus(Http::OK());
        $this->assertAuthenticatedAs($user);
    }

    /**
     * A basic feature test example.
     */
    public function testCanUserRegister(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserRaw();

        $data = [
            'email' => $user['email'],
            'name' => $user['name'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);

        $this->hasAllAssertJson($response, ['token', 'expires_in', 'token_type']);
        $response->assertStatus(Http::OK());
    }

    public function testCanUserLogout(): void
    {
        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(Http::NO_CONTENT());
    }

    public function testCanUserGetDetalis(): void
    {
        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->getJson('/api/authenticated-user-details');

        $this->hasAllAssertJson($response, ['success', 'message', 'data', 'data.user']);
        $response->assertStatus(Http::OK());
    }

    protected function hasAllAssertJson($response, array $attributes = [])
    {
        return $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll($attributes)
        );
    }
}
