<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TelegramTest extends TestCase
{
    use WithFaker;

    /**
     * Testing message creation
     *
     * @return void
     */
    public function testMessageRegister()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/messages', ["message" => "Test Message - {$this->faker->sentences[0]}"]);
        $response->assertStatus(201);
    }

    /**
     * Testing messages fetch
     *
     * @return void
     */
    public function testMessagesFetch()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/messages');
        $response->assertStatus(200);
    }

    /**
     * Testing message show
     *
     * @return void
     */
    public function testMessageShow()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/messages/1');
        $response->assertStatus(200);
    }
}
