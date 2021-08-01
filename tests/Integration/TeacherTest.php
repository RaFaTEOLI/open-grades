<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Role;

class TeacherTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should create a new teacher using the invitation link
     *
     * @return void
     */
    public function testShouldCreateANewTeacherUsingInvitationLink()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/invitations', ["type" => "TEACHER"]);

        $teacher = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "hash" => $response["hash"]
        ];

        $response = $this->json('POST', env('APP_API') . '/register', $teacher);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should create a new teacher
     *
     * @return void
     */
    public function testShouldCreateANewTeacher()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/teachers", [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail,
            "password" => "password",
        ]);

        $response->assertStatus(HttpStatus::CREATED)->assertJsonStructure(['id', 'name', 'email']);
    }

    /**
     * It should list all teachers
     *
     * @return void
     */
    public function testShouldListAllTeachers()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/teachers");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name', 'email']]);
    }

    /**
     * It should show a teacher by id
     *
     * @return void
     */
    public function testShouldShowATeacherById()
    {
        $user = User::find(1);

        $teacher = factory(User::class)->create();
        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/teachers/{$teacher->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'name', 'email']);
    }

    /**
     * It should update a teacher
     *
     * @return void
     */
    public function testShouldUpdateTeacher()
    {
        $user = User::find(1);

        $teacher = factory(User::class)->create();
        $teacherRole = Role::where("name", "teacher")->first();
        $teacher->attachRole($teacherRole);

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/teachers/{$teacher->id}", [
            "name" => "Updated Name",
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of teachers with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfTeachersWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/teachers?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
