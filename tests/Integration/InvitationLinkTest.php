<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\InvitationLink;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvitationLinkTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * It should create a new invitation link for student
     *
     * @return void
     */
    public function testShouldCreateANewInvitationLinkForStudent()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "STUDENT"]);
        $response->assertStatus(HttpStatus::CREATED);
        $response->assertJson(['type' => 'STUDENT']);
    }

    /**
     * It should create a new invitation link for teacher
     *
     * @return void
     */
    public function testShouldCreateANewInvitationLinkForTeacher()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "TEACHER"]);
        $response->assertStatus(HttpStatus::CREATED);
        $response->assertJson(['type' => 'TEACHER']);
    }

    /**
     * It should not delete an invitation that has been used
     *
     * @return void
     */
    public function testShouldNotDeleteAnInvitationThatHasBeenUsed()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "TEACHER"]);

        $invitationLinkRepository = new InvitationLinkRepository();
        $invitationLinkRepository->update($response->original->id, ["used_at" => Carbon::now()]);

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/invitations/{$response->original->id}");

        $response->assertStatus(HttpStatus::BAD_REQUEST);
    }

    /**
     * It should fetch all invitations
     *
     * @return void
     */
    public function testShouldFetchAllInvitations()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/invitations");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'user', 'student', 'hash', 'link', 'type']]);
    }

    /**
     * It should fetch an invitations by id
     *
     * @return void
     */
    public function testShouldFetchAnInvitationById()
    {
        $user = User::find(1);
        Auth::login($user);

        $invitationLink = factory(InvitationLink::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/invitations/{$invitationLink->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'user', 'student', 'hash', 'link', 'type']);
    }

    /**
     * It should delete an invitation link
     *
     * @return void
     */
    public function testShouldDeleteAnInvitationLinkById()
    {
        $user = User::find(1);
        Auth::login($user);

        $invitationLink = factory(InvitationLink::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/invitations/{$invitationLink->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of invitations with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfInvitationsWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/invitations?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
