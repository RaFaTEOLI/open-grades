<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ConfigurationTest extends TestCase
{
    use WithFaker;

    /**
     * Testing configuration fetch
     *
     * @return void
     */
    public function testConfigurationFetch()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/configurations');
        $response->assertStatus(200);
    }

    /**
     * Testing configuration show
     *
     * @return void
     */
    public function testConfigurationShow()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('GET', env('APP_API') . '/configurations/1');
        $response->assertStatus(200);
    }

    /**
     * Testing configuration creation
     *
     * @return void
     */
    public function testConfigurationRegister()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('POST', env('APP_API') . '/configurations', ["name" => "test_config-{$this->faker->name}", "value" => "1"]);
        $response->assertStatus(201);
    }

    /**
     * Testing configuration update
     *
     * @return void
     */
    public function testConfigurationUpdate()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('PUT', env('APP_API') . '/configurations/3', ["name" => "test_config-{$this->faker->name}", "value" => "0"]);
        $response->assertStatus(204);
    }

    /**
     * Testing configuration delete
     *
     * @return void
     */
    public function testConfigurationDelete()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . '/configurations/2');
        $response->assertStatus(204);
    }
}
