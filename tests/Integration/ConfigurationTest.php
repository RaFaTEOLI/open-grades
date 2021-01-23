<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConfigurationTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * It should return all configurations
     *
     * @return void
     */
    public function testConfigurationFetch()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/configurations');
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should create a new configuration
     *
     * @return void
     */
    public function testConfigurationRegister()
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
    public function testConfigurationShow()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/configurations/1');
        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should update a configuration
     *
     * @return void
     */
    public function testConfigurationUpdate()
    {
        $user = User::find(1);
        $configToUpdate = User::create([
                'name' => $this->faker->name,
                'value' => '1'
            ]);

        $response = $this->actingAs($user, 'api')->json('PUT', env('APP_API') . "/configurations/{$configToUpdate->id}", ["value" => "0"]);
        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJson([
            "value" => "0"
        ]);
    }

    /**
     * It should deletea configuration
     *
     * @return void
     */
    public function testConfigurationDelete()
    {
        $user = User::find(1);
        $configToDelete = User::create([
            'name' => $this->faker->name,
            'value' => '1'
        ]);

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/configurations/{$configToDelete->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }
}
