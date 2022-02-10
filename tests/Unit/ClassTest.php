<?php

namespace Tests\Unit;

use App\Models\Grade;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Year;
use App\Services\Class\CreateClassService;
use Exception;

class ClassTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new class
     *
     * @return void
     */
    public function testShouldCreateANewClass()
    {
        $user = factory(User::class)->create();

        factory(Year::class)->create();
        $subject = factory(Subject::class)->create();
        $grade = factory(Grade::class)->create();
        $teacher = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $this->actingAs($user);

        $class = (new CreateClassService())->execute([
            "subject_id" => $subject->id,
            "grade_id" => $grade->id,
            "user_id" => $teacher->id,
        ]);

        $this->assertTrue(is_numeric($class->id));
    }

    /**
     * It should not create a new class because year is not open
     *
     * @return void
     */
    public function testShouldNotCreateANewClassBecauseYearIsNotOpen()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();
        factory(Year::class)->create();

        $year = Year::where('closed', 0)->first()->get();

        if ($year) {
            $year->update(['closed' => 1]);
        }

        $subject = factory(Subject::class)->create();
        $grade = factory(Grade::class)->create();
        $teacher = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $this->actingAs($user);

        (new CreateClassService())->execute([
            "subject_id" => $subject->id,
            "grade_id" => $grade->id,
            "user_id" => $teacher->id,
        ]);
    }
}
