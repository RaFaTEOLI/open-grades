<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\InvitationLink\InvitationLinkRepository;
use Carbon\Carbon;

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
}
