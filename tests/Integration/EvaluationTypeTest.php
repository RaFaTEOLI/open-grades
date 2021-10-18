<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\EvaluationType;

class EvaluationTypeTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new EvaluationType
     *
     * @return void
     */
    public function testShouldCreateANewEvaluationType()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/evaluation-types", [
            "name" => $this->faker->word(),
            "weight" => $this->faker->numberBetween(1, 1000),
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all EvaluationTypes
     *
     * @return void
     */
    public function testShouldListAllEvaluationTypes()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/evaluation-types");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'name', 'weight']]);
    }

    /**
     * It should show a Grade by id
     *
     * @return void
     */
    public function testShouldShowAnEvaluationTypeById()
    {
        $user = User::find(1);

        $grade = factory(EvaluationType::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/evaluation-types/{$grade->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'name', 'weight']);
    }

    /**
     * It should delete a EvaluationType by id
     *
     * @return void
     */
    public function testShouldDeleteAEvaluationTypeById()
    {
        $user = User::find(1);

        $grade = factory(EvaluationType::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/evaluation-types/{$grade->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a EvaluationType
     *
     * @return void
     */
    public function testShouldUpdateEvaluationType()
    {
        $user = User::find(1);

        $grade = factory(EvaluationType::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/evaluation-types/{$grade->id}", [
            "name" => $this->faker->word(),
            "weight" => $this->faker->numberBetween(1, 1000),
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of EvaluationTypes with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfEvaluationTypesWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/evaluation-types?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
