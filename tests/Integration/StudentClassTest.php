<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\Classes;
use App\Models\Role;
use App\Models\StudentsClasses;
use App\Models\StudentsResponsible;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class StudentClassTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should enroll student to class
     *
     * @return void
     */
    public function testShouldEnrollAStudentToClass()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $class = factory(Classes::class)->create();

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/student/classes", [
            "class_id" => $class->id,
            "student_id" => $student->id,
        ]);

        $response->assertStatus(HttpStatus::CREATED)->assertJsonStructure(['id', 'user', 'class', 'presence', 'absent', 'enroll_date', 'left_date']);
    }

    /**
     * It should list all student classes
     *
     * @return void
     */
    public function testShouldListAllStudentClasses()
    {
        $user = User::find(1);
        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/student/{$student->id}/classes");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['classes', 'studentId']);
    }

    /**
     * It should show a student class by id
     *
     * @return void
     */
    public function testShouldShowAStudentClassById()
    {
        $user = User::find(1);

        $studentClass = factory(StudentsClasses::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/student/classes/{$studentClass->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'user', 'class', 'presence', 'absent', 'enroll_date', 'left_date']);
    }

    /**
     * It should update a student class
     *
     * @return void
     */
    public function testShouldUpdateStudentClass()
    {
        $user = User::find(1);
        $studentClass = factory(StudentsClasses::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/student/classes/{$studentClass->id}", [
            "presence" => 8,
            "absent" => 4,
            "left_date" => "2021-06-12 10:00:00"
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete a student class
     *
     * @return void
     */
    public function testShouldDeleteAStudentClass()
    {
        $user = User::find(1);

        $studentClass = factory(StudentsClasses::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/student/classes/{$studentClass->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of student classes with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfStudentsWithLimitAndOffset()
    {
        $user = User::find(1);
        factory(StudentsClasses::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/student/classes?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original["classes"]) == 1);
    }
}
