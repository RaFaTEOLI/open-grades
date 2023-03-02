<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Services\Role\CreateRoleService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\User;
use App\Services\RolePermission\RemoveRolePermissionService;
use App\Services\RolePermission\UpdateRolePermissionService;
use Exception;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new role
     *
     * @return void
     */
    public function testShouldCreateANewRole()
    {
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $createdRole = (new CreateRoleService())->execute([
            "name" => $this->faker->name(),
            "display_name" => $this->faker->name(),
            "description" => $this->faker->name(),
        ]);

        $this->assertTrue(is_numeric($createdRole->id));
    }

    /**
     * It should add a permission to a role
     *
     * @return void
     */
    public function testShouldAddPermissionToRole()
    {
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $permission = Permission::find(1);

        $roleTest = factory(Role::class)->create();

        $roleUpdate = (new UpdateRolePermissionService())->execute([
            "roleId" => $roleTest->id,
            "permissionId" => $permission->id,
        ]);

        $this->assertTrue($roleUpdate->permissions[0]->id == $permission->id);
    }

    /**
     * It should delete a permission to a role
     *
     * @return void
     */
    public function testShouldDeletePermissionToRole()
    {
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $permission = Permission::find(1);

        $roleTest = factory(Role::class)->create();

        (new UpdateRolePermissionService())->execute([
            "roleId" => $roleTest->id,
            "permissionId" => $permission->id,
        ]);

        $roleDelete = (new RemoveRolePermissionService())->execute([
            "roleId" => $roleTest->id,
            "permissionId" => $permission->id,
        ]);

        $this->assertTrue(count($roleDelete->permissions) == 0);
    }

    /**
     * It should not create a new empty Role
     *
     * @return void
     */
    public function testShouldNotCreateANewEmptyRole()
    {
        $this->expectException(Exception::class);
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        (new CreateRoleService())->execute([]);
    }

    /**
     * It should not delete a permission to a role because request is invalid
     *
     * @return void
     */
    public function testShouldNotDeletePermissionToRoleBecauseRequestIsInvalid()
    {
        $this->expectException(Exception::class);
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $permission = Permission::find(1);

        $roleTest = factory(Role::class)->create();

        (new UpdateRolePermissionService())->execute([
            "roleId" => $roleTest->id,
            "permissionId" => $permission->id,
        ]);

        (new RemoveRolePermissionService())->execute([
            "roleId" => $this->faker->text(),
            "permissionId" => $this->faker->text(),
        ]);
    }

    /**
     * It should not add a permission to a role because request is invalid
     *
     * @return void
     */
    public function testShouldNotAddPermissionToRoleBecauseRequestIsInvalid()
    {
        $this->expectException(Exception::class);
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        (new UpdateRolePermissionService())->execute([
            "roleId" => $this->faker->text(),
            "permissionId" => $this->faker->text(),
        ]);
    }
}
