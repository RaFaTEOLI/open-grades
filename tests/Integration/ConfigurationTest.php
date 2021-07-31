<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use App\Models\Configuration;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class ConfigurationTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should return all configurations
     *
     * @return void
     */
    public function testShouldFetchAllConfigurations()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/configurations');
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should return the list of configurations with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfConfigurationsWithLimitAndOffset()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/configurations?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }

    /**
     * It should create a new configuration
     *
     * @return void
     */
    public function testShouldCreateANewConfiguration()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/configurations', ["name" => "test_config-{$this->faker->name}", "value" => "1"]);
        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should return a configuration by id
     *
     * @return void
     */
    public function testShouldFetchAConfigurationById()
    {
        $user = User::find(1);

        $configuration = factory(Configuration::class)->create();

        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . "/configurations/{$configuration->id}");
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should update a configuration
     *
     * @return void
     */
    public function testShouldUpdateAConfigurationById()
    {
        $user = User::find(1);
        $configToUpdate = factory(Configuration::class)->create();

        $response = $this->actingAs($user, 'api')->json('PUT', env('APP_API') . "/configurations/{$configToUpdate->id}", ["value" => "0"]);
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete a configuration
     *
     * @return void
     */
    public function testShouldDeleteAConfigurationById()
    {
        $user = User::find(1);
        $configToDelete = factory(Configuration::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/configurations/{$configToDelete->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }
}
