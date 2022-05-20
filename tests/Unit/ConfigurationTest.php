<?php

namespace Tests\Unit;

use App\Exceptions\UserNotAdmin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\Configuration\CreateConfigurationService;
use Exception;

class ConfigurationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new configuration
     *
     * @return void
     */
    public function testShouldCreateANewConfiguration()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $configuration = (new CreateConfigurationService())->execute([
            "name" => $this->faker->name,
            "value" => $this->faker->numberBetween(0, 10)
        ]);

        $this->assertTrue(is_numeric($configuration->id));
    }

    /**
     * It should not create a new configuration because user is not admin
     *
     * @return void
     */
    public function testShouldNotCreateANewConfigurationBecauseUserIsNotAdmin()
    {
        $this->expectException(UserNotAdmin::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "teacher")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new CreateConfigurationService())->execute([
            "name" => $this->faker->name,
            "value" => $this->faker->numberBetween(0, 10)
        ]);
    }

    /**
     * It should not create a new empty configuration
     *
     * @return void
     */
    public function testShouldNotCreateANewEmptyConfiguration()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new CreateConfigurationService())->execute([]);
    }
}
