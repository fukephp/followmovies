<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testCanUserLogin(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            'email' => 'test@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200);
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

        $response->assertStatus(200);
    }
}
