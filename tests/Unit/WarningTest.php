<?php

namespace Tests\Unit;

use App\Models\Classes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Year;
use App\Services\StudentsResponsible\AddStudentsResponsibleService;
use App\Services\Warning\CreateWarningService;
use Exception;
use Illuminate\Support\ItemNotFoundException;

class WarningTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new warning
     *
     * @return void
     */
    public function testShouldCreateANewWarning()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        factory(Year::class)->create();
        $class = factory(Classes::class)->create();
        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $this->actingAs($user);

        $class = (new CreateWarningService())->execute([
            "student_id" => $student->id,
            "class_id" => $class->id,
            "description" => $this->faker->sentence(2)
        ]);

        $this->assertTrue(is_numeric($class->id));
    }

    /**
     * It should create a new warning for a student with responsibles
     *
     * @return void
     */
    public function testShouldCreateANewWarningForAStudentWithResponsibles()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        factory(Year::class)->create();
        $class = factory(Classes::class)->create();
        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $this->actingAs($user);

        (new AddStudentsResponsibleService())->execute(['student_id' => $student->id, 'responsible_id' => $user->id]);

        $class = (new CreateWarningService())->execute([
            "student_id" => $student->id,
            "class_id" => $class->id,
            "description" => $this->faker->sentence(2)
        ]);

        $this->assertTrue(is_numeric($class->id));
    }


    /**
     * It should throw ItemNotFoundException exception
     *
     * @return void
     */
    public function testShouldThrowItemNotFoundException()
    {
        $this->expectException(ItemNotFoundException::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        factory(Year::class)->create();
        $class = factory(Classes::class)->create();
        $teacher = factory(User::class)->create();

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $this->actingAs($user);

        (new CreateWarningService())->execute([
            "student_id" => $teacher->id,
            "class_id" => $class->id,
            "description" => $this->faker->sentence(2)
        ]);
    }

    /**
     * It should throw Exception
     *
     * @return void
     */
    public function testShouldThrowException()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        factory(Year::class)->create();
        $class = factory(Classes::class)->create();
        $teacher = factory(User::class)->create();

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $this->actingAs($user);

        (new CreateWarningService())->execute([]);
    }
}
