<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\StudentsResponsible\AddStudentsResponsibleService;
use App\Services\StudentsResponsible\RemoveStudentsResponsibleService;
use App\Services\StudentsResponsible\UpdateStudentsResponsibleService;
use Exception;

class StudentResponsibleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should add a student responsible
     *
     * @return void
     */
    public function testShouldAddAStudentResponsible()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $responsible = (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);

        $this->assertTrue(is_numeric($responsible->id));
    }

    /**
     * It should remove a student responsible
     *
     * @return void
     */
    public function testShouldRemoveAStudentResponsible()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);

        $removed = (new RemoveStudentsResponsibleService())->execute([
            "student_id" => $student->id,
            "responsible_id" => $user->id,
        ]);

        $this->assertTrue($removed);
    }

    /**
     * It should update a student responsible by hash
     *
     * @return void
     */
    public function testShouldUpdateStudentResponsibleByHash()
    {
        $userAdmin = factory(User::class)->create();
        $roleAdmin = Role::where("name", "admin")->first();
        $userAdmin->attachRole($roleAdmin);

        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);

        $this->actingAs($userAdmin);
        $invitationLink = (new CreateInvitationLinkService())->execute([
            "type" => "RESPONSIBLE",
            "student_id" => $student->id,
        ]);

        $this->actingAs($user);
        $updated = (new UpdateStudentsResponsibleService())->execute(["hash" => $invitationLink->hash]);

        $this->assertTrue($updated);
    }

    /**
     * It should not add a student responsible when request is empty
     *
     * @return void
     */
    public function testShouldNotAddAStudentResponsibleWhenRequestIsEmpty()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new AddStudentsResponsibleService())->execute([]);
    }

    /**
     * It should not remove a student responsible when request is invalid
     *
     * @return void
     */
    public function testShouldNotRemoveAStudentResponsibleWhenRequestIsInvalid()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);
        (new RemoveStudentsResponsibleService())->execute([
            "student_id" => $this->faker->text(),
            "responsible_id" => $this->faker->text(),
        ]);
    }

    /**
     * It should not update a student responsible when hash is invalid
     *
     * @return void
     */
    public function testShouldNotUpdateStudentResponsibleByHashWhenHashIsInvalid()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();
        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);

        $this->actingAs($user);
        (new UpdateStudentsResponsibleService())->execute(["hash" => $this->faker->text()]);
    }
}
