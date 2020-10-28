<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class InvitationLinkTest extends TestCase
{
    /**
     * Testing invitation link creation
     *
     * @return void
     */
    public function testInvitationLinkRegister()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "STUDENT"]);
        $response->assertStatus(201);
    }
}
