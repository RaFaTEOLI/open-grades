<?php

namespace Tests\Integration;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\HttpStatus;
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
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/users');

        $response->assertStatus(HttpStatus::SUCCESS);
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('12345678')
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/users/1');

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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('12345678')
        ]);

        $response = $this->actingAs($user, 'api')->json('PUT', env('APP_API') . "/users/{$userToUpdate->id}", ["name" => "UpdatedName"]);
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return 401 because the user is not authorized to access this endpoint
     *
     * @return void
     */
    public function testShouldNotReturnUsersBecauseUserIsNotAuthorized()
    {
        $response = $this->json('GET', env('APP_API') . '/users');

        $response->assertStatus(HttpStatus::UNAUTHORIZED);
    }

    /**
     * It should not create a new user because a valid hash isn't being used
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseHashIsInvalid()
    {
        $user = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];

        $response = $this->json('POST', env('APP_API') . '/register', $user);

        $response->assertStatus(HttpStatus::BAD_REQUEST);
    }

    /**
     * It should not create a new user because the email already exists
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseEmailAlreadyExists()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "TEACHER"]);

        $user = [
            "name" => $this->faker->name,
            "email" => "opengrades@gmail.com",
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["hash"]
        ];

        $response = $this->json('POST', env('APP_API') . '/register', $user);

        $response->assertStatus(HttpStatus::BAD_REQUEST);
    }
}
