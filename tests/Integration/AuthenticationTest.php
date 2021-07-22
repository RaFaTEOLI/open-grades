<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Testing login
     *
     * @return void
     */
    public function testShouldLogUserIn()
    {
        $user = [
            "email" => "opengrades@gmail.com",
            "password" => "password",
        ];

        $response = $this->json("POST", env("APP_API") . "/login", $user);

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(["access_token", "token_type", "expires_in"]);
    }

    /**
     * Testing failed login
     *
     * @return void
     */
    public function testShoutNotLogUserInBecauseOfWrongCredentials()
    {
        $user = [
            "email" => "itdoesntexist@gmail.com",
            "password" => "password",
        ];

        $response = $this->json("POST", env("APP_API") . "/login", $user);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY)->assertJson([
            "error" => "Sorry, wrong email address or password. Please try again",
        ]);
    }
}
