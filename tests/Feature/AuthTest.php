<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $response->assertStatus(Http::OK());
    }

    public function testCanUserLogout(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(Http::OK());
    }
}
