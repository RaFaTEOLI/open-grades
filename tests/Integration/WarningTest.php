<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Classes;
use App\Models\Role;
use App\Models\StudentsResponsible;
use Illuminate\Support\Facades\Auth;
use App\Models\Warning;
use App\Models\Year;

class WarningTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Warning
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

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/warnings", [
            "student_id" => $student->id,
            "class_id" => $class->id,
            "description" => $this->faker->sentence(2)
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Warnings
     *
     * @return void
     */
    public function testShouldListAllWarnings()
    {
        $user = User::find(1);
        Auth::login($user);
        factory(Warning::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'student', 'class', 'reporter', 'description']]);
    }

    /**
     * It should show a Warning by id
     *
     * @return void
     */
    public function testShouldShowAWarningById()
    {
        $user = User::find(1);
        Auth::login($user);

        $warning = factory(Warning::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings/{$warning->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'student', 'class', 'reporter', 'description']);
    }

    /**
     * It should delete a Warning by id
     *
     * @return void
     */
    public function testShouldDeleteAWarningById()
    {
        $user = User::find(1);
        Auth::login($user);

        $warning = factory(Warning::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/warnings/{$warning->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a Warning
     *
     * @return void
     */
    public function testShouldUpdateWarning()
    {
        $user = User::find(1);
        Auth::login($user);

        $warning = factory(Warning::class)->create();

        $response = $this->actingAs($user, "api")->json("PATCH", env("APP_API") . "/warnings/{$warning->id}", [
            "description" => $this->faker->sentence(2)
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
        Auth::login($user);

        factory(Warning::class)->create();
        factory(Warning::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings?offset=1&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }

    /**
     * It should list Warnings for teacher
     *
     * @return void
     */
    public function testShouldListWarningsForTeacher()
    {
        $class = factory(Classes::class)->create();
        $user = User::find($class->user_id);
        Auth::login($user);

        factory(Warning::class)->create(["class_id" => $class->id]);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings");

        $response->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'student', 'class', 'reporter', 'description']]);
    }

    /**
     * It should list Warnings for Student
     *
     * @return void
     */
    public function testShouldListWarningsForStudent()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "student")->first();
        $user->attachRole($role);
        Auth::login($user);

        factory(Warning::class)->create(["student_id" => $user->id]);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings");

        $response->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'student', 'class', 'reporter', 'description']]);
    }

    /**
     * It should list Warnings for Responsible
     *
     * @return void
     */
    public function testShouldListWarningsForResponsible()
    {
        $studentResponsible = factory(StudentsResponsible::class)->create();
        $user = User::find($studentResponsible->responsible_id);
        Auth::login($user);

        factory(Warning::class)->create(["student_id" => $studentResponsible->student_id]);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/warnings");

        $response->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'student', 'class', 'reporter', 'description']]);
    }
}
