<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * Testing users list
     *
     * @return void
     */
    public function testUsersList()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/users');

        $response->assertStatus(200);
    }

     /**
     * Testing users show by id
     *
     * @return void
     */
    public function testUserShow()
    {
        // $response = $this->withHeaders([
        //     'Authorization' => 'Bearer ' . env('API_TOKEN'),
        // ])->json('GET', env('APP_API') . '/users/1');
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/users/1');

        $response->assertStatus(200);
    }

    /**
     * Testing unauthorized user
     *
     * @return void
     */
    public function testUnauthorizedUser()
    {
        $response = $this->json('GET', env('APP_API') . '/users');

        $response->assertStatus(401);
    }
}
