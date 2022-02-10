<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\Telegram;
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
        $response = $this->actingAs($user, "api")->json(
            "POST",
            env("APP_API") . "/messages",
            ["message" => "Test Message - {$this->faker->sentences[0]}"],
        );
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

        factory(Telegram::class)->create();

        $response = $this->actingAs($user, "api")->json(
            "GET",
            env("APP_API") . "/messages",
        );
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

        $telegramMessage = factory(Telegram::class)->create();

        $response = $this->actingAs($user, "api")->json(
            "GET",
            env("APP_API") . "/messages/{$telegramMessage->id}",
        );
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should return the list of messages with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfMessagesWithLimitAndOffset()
    {
        $user = User::find(1);
        factory(Telegram::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/messages?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
