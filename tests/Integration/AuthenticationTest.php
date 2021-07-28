<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\Role;
use App\Models\User;
use App\Services\InvitationLink\CreateInvitationLinkService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * It should log user in
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
     * It should sign user up
     *
     * @return void
     */
    public function testShouldSignUserUp()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $invitationLink = (new CreateInvitationLinkService())->execute([
            "type" => "STUDENT",
        ]);

        $user = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => $this->faker->password(8, 10),
            "hash" => $invitationLink->hash
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $user);

        $response
            ->assertStatus(HttpStatus::CREATED)
            ->assertJsonStructure(["name", "email", "photo"]);
    }

    /**
     * It should log user out
     *
     * @return void
     */
    public function testShouldLogUserOut()
    {
        $user = factory(User::class)->create();

        $loginResponse = $this->json('POST', env('APP_API') . '/login', ["email" => $user->email, "password" => "password"]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $loginResponse->original["access_token"])->json("GET", env("APP_API") . "/logout");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJson(['message' => 'User successfully signed out']);
    }

    /**
     * It should not log user in because of wrong credentials
     *
     * @return void
     */
    public function testShouldNotLogUserInBecauseOfWrongCredentials()
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

    /**
     * It should show logged user details
     *
     * @return void
     */
    public function testShouldShowLoggedUserDetails()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/details");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJson(['name' => $user->name, 'email' => $user->email]);
    }
}
