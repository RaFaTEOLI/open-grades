<?php

namespace Tests\Unit;

use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\User\CreateUserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new user
     *
     * @return void
     */
    public function testUserCreation()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $invitationLink = (new CreateInvitationLinkService($user))->execute(['type' => 'STUDENT']);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '12345678',
            "hash" => $invitationLink->hash
        ]);

        $this->assertTrue(is_numeric($createdUser->id));
    }
}
