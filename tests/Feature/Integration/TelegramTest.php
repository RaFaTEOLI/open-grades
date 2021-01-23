<?php

namespace Tests\Feature\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TelegramTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should create a message
     *
     * @return void
     */
    public function testShouldCreateANewMessage()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/messages', ["message" => "Test Message - {$this->faker->sentences[0]}"]);
        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should return messages
     *
     * @return void
     */
    public function testShouldFetchMessages()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/messages');
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should return a message by id
     *
     * @return void
     */
    public function testShouldFetchMessageById()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/messages/1');
        $response->assertStatus(HttpStatus::SUCCESS);
    }
}
