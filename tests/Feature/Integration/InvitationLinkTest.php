<?php

namespace Tests\Feature\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

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
}
