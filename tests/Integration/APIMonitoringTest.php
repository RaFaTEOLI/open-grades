<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use Tests\TestCase;

class APIMonitoringTest extends TestCase
{
    /**
     * It should fetch metrics
     *
     * @return void
     */
    public function testShouldFetchMetrics()
    {
        $response = $this->json("GET", env("APP_API") . "/metrics");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['average_response_time', 'requests_count']);
    }

    /**
     * It should fetch API version
     *
     * @return void
     */
    public function testShouldFetchVersion()
    {
        $response = $this->json("GET", env("APP_API") . "/version");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertExactJson(['version' => env("APP_VERSION")]);
    }

    /**
     * It should fetch API version
     *
     * @return void
     */
    public function testShouldFetchHealth()
    {
        $response = $this->json("GET", env("APP_API") . "/health");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertExactJson(['message' => "It's working"]);
    }
}
