<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Permission;
use App\Models\Role;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get("/");

        $response->assertStatus(200);
    }

    /**
     * It should create a new role
     *
     * @return void
     */
    public function testShouldCreateANewRole()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/roles", [
            "name" => $this->faker->name(),
            "display_name" => $this->faker->name(),
            "description" => $this->faker->name(),
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should add a permission to a role
     *
     * @return void
     */
    public function testShouldAddPermissionToRole()
    {
        $user = User::find(1);

        $role = factory(Role::class)->create();

        $permission = Permission::find(1);

        $response = $this->actingAs($user, "api")->json(
            "PATCH",
            env("APP_API") . "/roles/{$role->id}/permission/{$permission->id}",
        );

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete a permission to a role
     *
     * @return void
     */
    public function testShouldDeletePermissionToRole()
    {
        $user = User::find(1);

        $role = factory(Role::class)->create();

        $permission = Permission::find(1);

        $this->actingAs($user, "api")->json("POST", env("APP_API") . "/roles/{$role->id}/permission/{$permission->id}");

        $response = $this->actingAs($user, "api")->json(
            "DELETE",
            env("APP_API") . "/roles/{$role->id}/permission/{$permission->id}",
        );

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }
}
