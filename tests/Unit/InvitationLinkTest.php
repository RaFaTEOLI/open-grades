<?php

namespace Tests\Unit;

use App\Services\InvitationLink\CreateInvitationLinkService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class InvitationLinkTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new invitation link
     *
     * @return void
     */
    public function testShouldCreateANewInvitationLink()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $invitationLink = (new CreateInvitationLinkService($user))->execute([
            "type" => "STUDENT",
        ]);

        $this->assertTrue(is_numeric($invitationLink->id));
        $this->assertTrue(strlen($invitationLink->hash) > 42);
    }
}
