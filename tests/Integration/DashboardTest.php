<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should get all dashboard data
     *
     * @return void
     */
    public function testShouldGetDashboardData()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/dashboard");

        $response->assertStatus(HttpStatus::SUCCESS);
        $response->assertJsonStructure(['totalStudents', 'newStudents', 'totalTeachers']);
    }
}
