<?php

namespace Tests\Integration;

use App\Http\Controllers\API\HttpStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MetricsTest extends TestCase
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
}
