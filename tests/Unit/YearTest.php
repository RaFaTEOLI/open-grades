<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\Year\OpenSchoolYearService;
use Exception;

class YearTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new school year
     *
     * @return void
     */
    public function testShouldCreateANewSchoolYear()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $year = (new OpenSchoolYearService())->execute([
            "start_date" => $this->faker->date('Y-m-d'),
            "end_date" => $this->faker->dateTimeBetween('+10 month', '+12 month')->format('Y-m-d')
        ]);

        $this->assertTrue(is_numeric($year->id));
    }

    /**
     * It should throw an exception when invalid data is provided
     *
     * @return void
     */
    public function testShouldThrowAnExceptionWhenInvalidDataIsProvided()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $year = (new OpenSchoolYearService())->execute([]);
    }
}
