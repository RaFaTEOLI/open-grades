<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Role;
use App\Models\StudentsClasses;
use App\Models\Subject;
use App\Models\Year;

class ClassTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Class
     *
     * @return void
     */
    public function testShouldCreateANewClass()
    {
        $user = User::find(1);

        factory(Year::class)->create();
        $subject = factory(Subject::class)->create();
        $grade = factory(Grade::class)->create();
        $teacher = factory(User::class)->create();

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/classes", [
            "subject_id" => $subject->id,
            "grade_id" => $grade->id,
            "user_id" => $teacher->id,
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Classes
     *
     * @return void
     */
    public function testShouldListAllClasses()
    {
        $user = User::find(1);
        factory(Classes::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/classes");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'year', 'subject', 'grade', 'user']]);
    }

    /**
     * It should show a Class by id
     *
     * @return void
     */
    public function testShouldShowAClassById()
    {
        $user = User::find(1);

        $class = factory(Classes::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/classes/{$class->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'year', 'subject', 'grade', 'user']);
    }

    /**
     * It should delete a Class by id
     *
     * @return void
     */
    public function testShouldDeleteAClassById()
    {
        $user = User::find(1);

        $class = factory(Classes::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/classes/{$class->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a class
     *
     * @return void
     */
    public function testShouldUpdateClass()
    {
        $user = User::find(1);

        $class = factory(Classes::class)->create();

        factory(Year::class)->create();
        $subject = factory(Subject::class)->create();
        $grade = factory(Grade::class)->create();
        $teacher = factory(User::class)->create();

        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/classes/{$class->id}", [
            "subject_id" => $subject->id,
            "grade_id" => $grade->id,
            "user_id" => $teacher->id,
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of Classes with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfClasssWithLimitAndOffset()
    {
        $user = User::find(1);
        factory(Classes::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/classes?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }

    /**
     * It should show students from a Class by id
     *
     * @return void
     */
    public function testShouldShowStudentsFromAClassById()
    {
        $user = User::find(1);

        $studentClass = factory(StudentsClasses::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/classes/{$studentClass->class_id}/students");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name', 'email', 'photo', 'created_at', 'updated_at', 'roles']]);
    }
}
