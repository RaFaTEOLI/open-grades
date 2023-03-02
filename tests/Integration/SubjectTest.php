<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Subject;

class SubjectTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Subject
     *
     * @return void
     */
    public function testShouldCreateANewSubject()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/subjects", [
            "name" => $this->faker->name(),
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Subjects
     *
     * @return void
     */
    public function testShouldListAllSubjects()
    {
        $user = User::find(1);
        factory(Subject::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/subjects");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name']]);
    }

    /**
     * It should show a Subject by id
     *
     * @return void
     */
    public function testShouldShowASubjectById()
    {
        $user = User::find(1);

        $subjects = factory(Subject::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/subjects/{$subjects->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'name']);
    }

    /**
     * It should delete a Subject by id
     *
     * @return void
     */
    public function testShouldDeleteASubjectById()
    {
        $user = User::find(1);

        $subjects = factory(Subject::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/subjects/{$subjects->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a subject
     *
     * @return void
     */
    public function testShouldUpdateSubject()
    {
        $user = User::find(1);

        $subject = factory(Subject::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/subjects/{$subject->id}", [
            "name" => $this->faker->name(),
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of Subjects with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfSubjectsWithLimitAndOffset()
    {
        $user = User::find(1);
        factory(Subject::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/subjects?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
