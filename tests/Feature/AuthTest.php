<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;

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
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(Http::NO_CONTENT());
    }

    public function testCanUserGetDetalis(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->getJson('/api/authenticated-user-details');

        $this->hasAllAssertJson($response, ['success', 'message', 'data', 'data.user']);
        $response->assertStatus(Http::OK());
    }
}
