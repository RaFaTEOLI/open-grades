<?php

namespace Tests\Integration;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * It should return the list of users
     *
     * @return void
     */
    public function testShouldFetchListOfUsers()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/users");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should return the list of users with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfUsersWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/users?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }

    /**
     * It should return the user by id
     *
     * @return void
     */
    public function testShouldFetchUserById()
    {
        $user = User::find(1);
        User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => Hash::make("12345678"),
        ]);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/users/1");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should update an user
     *
     * @return void
     */
    public function testShouldUpdateAnUser()
    {
        $user = User::find(1);
        $userToUpdate = User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => Hash::make("12345678"),
        ]);

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/users/{$userToUpdate->id}", [
            "name" => "UpdatedName",
        ]);
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return 401 because the user is not authorized to access this endpoint
     *
     * @return void
     */
    public function testShouldNotReturnUsersBecauseUserIsNotAuthorized()
    {
        $response = $this->json("GET", env("APP_API") . "/users");

        $response->assertStatus(HttpStatus::UNAUTHORIZED);
    }

    /**
     * It should not create a new user because a valid hash isn't being used
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseHashIsNotBeingUsed()
    {
        $user = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $user);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * It should not create a new user because the email already exists
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseEmailAlreadyExists()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/invitations", ["type" => "TEACHER"]);

        $user = [
            "name" => $this->faker->name,
            "email" => "opengrades@gmail.com",
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["hash"],
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $user);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * It should not add a role to the user because the user is not admin
     *
     * @return void
     */
    public function testShouldNotAddARoleToUserBecauseUserIsNotAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, "api")->json("PATCH", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::FORBIDDEN);
    }

    /**
     * It should not delete user's role because the user is not admin
     *
     * @return void
     */
    public function testShouldNotDeleteUsersRoleBecauseUserIsNotAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, "api")->json("DELETE", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::FORBIDDEN);
    }

    /**
     * It should not delete admin role from user because user is admin
     *
     * @return void
     */
    public function testShouldNotDeleteAdminRoleFromUserBecauseUserIsAdmin()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("DELETE", env("APP_API") . "/users/{$user->id}/role/1");

        $response->assertStatus(HttpStatus::BAD_REQUEST);
    }

    /**
     * It should delete an user by id
     *
     * @return void
     */
    public function testShouldDeleteAnUserById()
    {
        $user = User::find(1);

        $userToDelete = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/users/{$userToDelete->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete user's role
     *
     * @return void
     */
    public function testShouldDeleteRoleFromUser()
    {
        $user = User::find(1);
        $userToDeleteRole = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $userToDeleteRole->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("DELETE", env("APP_API") . "/users/{$userToDeleteRole->id}/role/{$studentRole->id}");

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should add role to user
     *
     * @return void
     */
    public function testShouldAddRoleToUser()
    {
        $user = User::find(1);

        $userToAddRole = factory(User::class)->create();
        $response = $this->actingAs($user, "api")->json("PATCH", env("APP_API") . "/users/{$userToAddRole->id}/role/1");

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should not create a new user because hash is invalid
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseHashIsInvalid()
    {
        $user = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $this->faker->word()
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $user);

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }
}
