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

class StudentTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should create a new student using the invitation link
     *
     * @return void
     */
    public function testShouldCreateANewStudentUsingInvitationLink()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/invitations", ["type" => "STUDENT"]);

        $student = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["hash"],
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $student);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should create a new student responsible using the invitation link
     *
     * @return void
     */
    public function testShouldCreateANewStudentResponsibleUsingInvitationLink()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/student-responsible", [
            "student_id" => $student->id,
        ]);

        $responsible = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["invitation"]["hash"],
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $responsible);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should remove a student responsible
     *
     * @return void
     */
    public function testShouldRemoveStudentResponsible()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/student-responsible", [
            "student_id" => $student->id,
        ]);

        $responsible = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["invitation"]["hash"],
        ];

        $response = $this->json("POST", env("APP_API") . "/register", $responsible);
        $responsibleId = $response["id"];

        $response = $this->json("DELETE", env("APP_API") . "/students/{$student->id}/responsible/{$responsibleId}");

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should create a new student's responsible invitation link
     *
     * @return void
     */
    public function testShouldCreateANewStudentResponsibleInvitationLink()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/student-responsible", [
            "student_id" => $student->id,
        ]);

        $response->assertStatus(HttpStatus::CREATED)->assertJsonStructure(['invitation' => ['student_id', 'type', 'user_id', 'hash', 'link']]);
    }

    /**
     * It should create a new student
     *
     * @return void
     */
    public function testShouldCreateANewStudent()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/students", [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail,
            "password" => "password",
        ]);

        $response->assertStatus(HttpStatus::CREATED)->assertJsonStructure(['id', 'name', 'email']);
    }

    /**
     * It should list all students
     *
     * @return void
     */
    public function testShouldListAllStudents()
    {
        $user = User::find(1);
        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/students");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name', 'email', 'responsibles']]);
    }

    /**
     * It should list all students as a responsible
     *
     * @return void
     */
    public function testShouldListAllStudentsAsAResponsible()
    {
        $studentsResponsible = factory(StudentsResponsible::class)->create();
        $user = User::find($studentsResponsible->responsible_id);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/students");

        $student = User::find($studentsResponsible->student_id);

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJson([['id' => $student->id, 'name' => $student->name, 'email' => $student->email]]);
    }

    /**
     * It should list all students as a teacher
     *
     * @return void
     */
    public function testShouldListAllStudentsAsATeacher()
    {
        $studentClass = factory(StudentsClasses::class)->create();

        $class = Classes::find($studentClass->class_id);
        $user = User::find($class->user_id);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/students");

        $student = User::find($studentClass->user_id);

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJson([['id' => $student->id, 'name' => $student->name, 'email' => $student->email]]);
    }

    /**
     * It should show a student by id
     *
     * @return void
     */
    public function testShouldShowAStudentById()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/students/{$student->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'name', 'email', 'responsibles']);
    }

    /**
     * It should update a student
     *
     * @return void
     */
    public function testShouldUpdateStudent()
    {
        $user = User::find(1);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/students/{$student->id}", [
            "name" => "Updated Name",
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete a student responsible
     *
     * @return void
     */
    public function testShouldDeleteAStudentResponsible()
    {
        $user = User::find(1);

        $studentsResponsible = factory(StudentsResponsible::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/students/{$studentsResponsible->student_id}/responsible/{$studentsResponsible->responsible_id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of students with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfStudentsWithLimitAndOffset()
    {
        $user = User::find(1);
        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $student = factory(User::class)->create();
        $student->attachRole($studentRole);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/students?offset=1&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
