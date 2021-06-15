<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\Role;
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

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/studentResponsible", [
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

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/studentResponsible", [
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
}
