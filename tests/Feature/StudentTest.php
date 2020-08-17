<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use WithFaker;
    /**
     * Testing student creation
     *
     * @return void
     */
    public function testStudentRegister()
    {
        $student = [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "type" => "STUDENT"
        ];

        $response = $this->json('POST', env('APP_API') . '/register', $student);

        $response->assertStatus(201);
    }
}
