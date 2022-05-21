<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\Telegram\CreateMessageService;
use Exception;

class TelegramTest extends TestCase
{
  use DatabaseTransactions;
  use WithFaker;

  /**
   * It should create a new message
   *
   * @return void
   */
  public function testShouldCreateANewMessage()
  {
    $user = factory(User::class)->create();
    $role = Role::where("name", "admin")->first();
    $user->attachRole($role);
    $this->actingAs($user);

    $message = (new CreateMessageService())->execute([
      "message" => $this->faker->sentence(4),
      "user_id" => $user->id
    ]);

    $this->assertIsNumeric($message->id);
  }

  /**
   * It should not create a new message because request is invalid
   *
   * @return void
   */
  public function testShouldNotCreateANewMessageBecauseRequestIsInvalid()
  {
    $this->expectException(Exception::class);
    $user = factory(User::class)->create();
    $role = Role::where("name", "admin")->first();
    $user->attachRole($role);
    $this->actingAs($user);

    (new CreateMessageService())->execute([]);
  }
}
