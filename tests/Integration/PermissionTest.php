<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should list all permissions
     *
     * @return void
     */
    public function testShouldListAllPermissions()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("get", env("APP_API") . "/permissions");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should list a permission
     *
     * @return void
     */
    public function testShouldListPermission()
    {
        $user = User::find(1);
        $permission = factory(Permission::class)->create();
        $response = $this->actingAs($user, "api")->json("get", env("APP_API") . "/permission/{$permission->id}");

        $response->assertStatus(HttpStatus::SUCCESS);
    }

    /**
     * It should create a new permission
     *
     * @return void
     */
    public function testShouldCreateANewPermission()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/permissions", [
            "name" => $this->faker->name(),
            "description" => $this->faker->name(),
            "create" => "on",
            "read" => "on",
            "update" => "on",
            "delete" => "on",
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a permission
     *
     * @return void
     */
    public function testShouldUpdatePermission()
    {
        $user = User::find(1);

        $permission = factory(Permission::class)->create();

        $response = $this->actingAs($user, "api")->json("PUT", env("APP_API") . "/permissions/{$permission->id}", [
            "name" => "Test",
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should delete a permission
     *
     * @return void
     */
    public function testShouldDeletePermission()
    {
        $user = User::find(1);

        $permission = factory(Permission::class)->create();

        $response = $this->actingAs($user, "api")->json("DELETE", env("APP_API") . "/permission/{$permission->id}");

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }
}
