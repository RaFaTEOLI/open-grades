<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Year;

class YearTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Year
     *
     * @return void
     */
    public function testShouldCreateANewYear()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/years", [
            "start_date" => $this->faker->date('Y-m-d'),
            "end_date" => $this->faker->dateTimeBetween('+10 month', '+12 month')->format('Y-m-d')
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Years
     *
     * @return void
     */
    public function testShouldListAllYears()
    {
        $user = User::find(1);

        factory(Year::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/years");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'start_date', 'end_date']]);
    }

    /**
     * It should show a Year by id
     *
     * @return void
     */
    public function testShouldShowAYearById()
    {
        $user = User::find(1);

        $year = factory(Year::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/years/{$year->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'start_date', 'end_date']);
    }

    /**
     * It should delete a Year by id
     *
     * @return void
     */
    public function testShouldDeleteAYearById()
    {
        $user = User::find(1);

        $year = factory(Year::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/years/{$year->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a year
     *
     * @return void
     */
    public function testShouldUpdateYear()
    {
        $user = User::find(1);

        $year = factory(Year::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/years/{$year->id}", [
            "start_date" => $this->faker->date('Y-m-d'),
            "end_date" => $this->faker->dateTimeBetween('+10 month', '+12 month')->format('Y-m-d')
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of Years with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfYearsWithLimitAndOffset()
    {
        $user = User::find(1);
        factory(Year::class)->create();
        factory(Year::class)->create();
        $responseNoLimit = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/years");
        $responseWithLimit = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/years?offset=1&limit=1");

        $responseNoLimit->assertStatus(HttpStatus::SUCCESS);
        $responseWithLimit->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($responseNoLimit->original) > 1);
        $this->assertTrue(count($responseWithLimit->original) == 1);
    }

    /**
     * It should not return the list of Years with invalid limit and offset
     *
     * @return void
     */
    public function testShouldNotFetchListOfYearsWithInvalidLimitAndOffset()
    {
        $user = User::find(1);
        factory(Year::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/years?offset=test&limit=nothingValid");

        $response->assertStatus(HttpStatus::UNPROCESSABLE_ENTITY);
    }
}
