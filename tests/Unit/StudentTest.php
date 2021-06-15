<?php

namespace Tests\Unit;

use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\User\CreateUserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\StudentsResponsible\RemoveStudentsResponsibleService;

class StudentTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new responsible invitation link
     *
     * @return void
     */
    public function testShouldCreateAResponsibleInvitationLink()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $request = [
            "student_id" => $student->id,
            "type" => "RESPONSIBLE",
        ];

        $createInvitationLinkService = new CreateInvitationLinkService();
        $invitationLink = $createInvitationLinkService->execute($request);

        $this->assertTrue(is_numeric($invitationLink->id));
        $this->assertTrue(strlen($invitationLink->hash) > 42);
    }

    /**
     * It should create a new responsible invitation link
     *
     * @return void
     */
    public function testShouldRemoveAResponsibleFromStudent()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $request = [
            "student_id" => $student->id,
            "type" => "RESPONSIBLE",
        ];

        $invitationLink = (new CreateInvitationLinkService())->execute($request);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "hash" => $invitationLink->hash,
        ]);

        $request = [
            "student_id" => $createdUser->id,
            "responsible_id" => $student->id,
        ];

        $result = (new RemoveStudentsResponsibleService())->execute($request);

        $this->assertTrue($result);
    }
}
