<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Testing login
     *
     * @return void
     */
    public function testLogin()
    {
        $user = [
            "email" => "opengrades@gmail.com",
            "password" => "password"
        ];

        $response = $this->json('POST', env('APP_API') . '/login', $user);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'token'
                ]
            ]);
    }

    /**
     * Testing failed login
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $user = [
            "email" => "itdoesntexist@gmail.com",
            "password" => "password"
        ];

        $response = $this->json('POST', env('APP_API') . '/login', $user);

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized'
            ]);
    }
}
