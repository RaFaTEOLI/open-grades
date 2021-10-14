<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Grade;

class GradeTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Grade
     *
     * @return void
     */
    public function testShouldCreateANewGrade()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/grades", [
            "name" => $this->faker->word(),
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Grades
     *
     * @return void
     */
    public function testShouldListAllGrades()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/grades");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name']]);
    }

    /**
     * It should show a Grade by id
     *
     * @return void
     */
    public function testShouldShowAGradeById()
    {
        $user = User::find(1);

        $grade = factory(Grade::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/grades/{$grade->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'name', 'classes']);
    }

    /**
     * It should delete a Grade by id
     *
     * @return void
     */
    public function testShouldDeleteAGradeById()
    {
        $user = User::find(1);

        $grade = factory(Grade::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/grades/{$grade->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a grade
     *
     * @return void
     */
    public function testShouldUpdateGrade()
    {
        $user = User::find(1);

        $grade = factory(Grade::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/grades/{$grade->id}", [
            "name" => $this->faker->name(),
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of Grades with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfGradesWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/grades?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
