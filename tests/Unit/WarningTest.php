<?php

namespace Tests\Unit;

use App\Models\Classes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Year;
use App\Services\Warning\CreateWarningService;

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
}
