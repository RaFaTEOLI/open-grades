<?php

namespace Tests\Unit;

use App\Exceptions\UserNotAdmin;
use App\Services\InvitationLink\CreateInvitationLinkService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use App\Services\InvitationLink\RemoveInvitationLinkService;
use Carbon\Carbon;
use Exception;

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

        $invitationLink = (new CreateInvitationLinkService())->execute([
            "type" => "STUDENT",
        ]);

        $this->assertTrue(is_numeric($invitationLink->id));
        $this->assertTrue(strlen($invitationLink->hash) > 42);
    }

    /**
     * It should not delete an used invitation link
     *
     * @return void
     */
    public function testShouldNotDeleteAnUsedInvitationLink()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $invitationLink = (new CreateInvitationLinkService())->execute([
            "type" => "STUDENT",
        ]);

        $invitationLinkRepository = new InvitationLinkRepository();
        $invitationLinkRepository->update($invitationLink->id, ["used_at" => Carbon::now()]);

        (new RemoveInvitationLinkService())->execute($invitationLink->id);
    }

    /**
     * It should not create a new invitation link because user is not admin
     *
     * @return void
     */
    public function testShouldNotCreateANewInvitationLinkBecauseUserIsNotAdmin()
    {
        $this->expectException(UserNotAdmin::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "teacher")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new CreateInvitationLinkService())->execute([
            "type" => "STUDENT",
        ]);
    }

    /**
     * It should not create a new empty invitation link
     *
     * @return void
     */
    public function testShouldNotCreateANewEmptyInvitationLink()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new CreateInvitationLinkService())->execute([]);
    }
}
