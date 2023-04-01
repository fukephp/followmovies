<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
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

        $response = $this->actingAs($user)->postJson(self::AUTH_API_PREFIX . '/login', $data);

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

        $response = $this->postJson(self::AUTH_API_PREFIX . '/register', $data);

        $this->hasAllAssertJson($response, ['token', 'expires_in', 'token_type']);
        $response->assertStatus(Http::OK());
    }

    public function testCanUserLogout(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->postJson(self::AUTH_API_PREFIX . '/logout');

        $response->assertStatus(Http::OK());
    }

    public function testCanUserGetDetalis(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $token = $this->createToken($user);

        $response = $this->actingAs($user)->getJson(self::AUTH_API_PREFIX . '/user-detalis');

        $this->hasAllAssertJson($response, ['success', 'message', 'data']);
        $response->assertStatus(Http::OK());
    }

    public function testCanUserSeeUnauthorizedErrorLogin()
    {
        $this->withoutExceptionHandling();

        $data = [
            'email' => 'example@email.com',
            'password' => 'password'
        ];

        $response = $this->postJson(self::AUTH_API_PREFIX . '/login', $data);

        $response->assertJson([
            'success' => false,
            'message' => 'Incorrect email/password'
        ])->assertStatus(Http::UNAUTHORIZED());
    }

    public function testCanUserSeeValidationErrorsLogin()
    {
        $data = [
            'email' => '',
            'password' => ''
        ];

        $response = $this->postJson(self::AUTH_API_PREFIX . '/login', $data);

        $response->assertStatus(Http::UNPROCESSABLE_ENTITY())
            ->assertJson(function (AssertableJson $json) use ($data) {
                $json->has('message')
                    ->has('errors', 2) // it will check the exact size of the errors bag
                    ->whereAllType([
                        'errors.email' => 'array',
                        'errors.password' => 'array',
                    ]);
            });
    }

    public function testCanUserSeeValidationErrorsRegister()
    {
        $user = $this->createUserRaw();

        $data = [
            'email' => '',
            'name' => $user['name'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(self::AUTH_API_PREFIX . '/register', $data);

        $response->assertStatus(Http::UNPROCESSABLE_ENTITY())
            ->assertJson(function (AssertableJson $json) use ($data) {
                $json->has('message')
                    ->has('errors', 1) // it will check the exact size of the errors bag
                    ->whereAllType([
                        'errors.email' => 'array',
                    ]);
            });
    }
}
