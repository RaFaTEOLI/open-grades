<?php

namespace Tests\Unit;

use App\Services\InvitationLink\CreateInvitationLinkService;
use App\Services\User\CreateUserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\User\RemoveUserRoleService;
use App\Services\User\UpdateUserRoleService;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new user
     *
     * @return void
     */
    public function testShouldCreateANewUser()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $invitationLink = (new CreateInvitationLinkService($user))->execute([
            "type" => "STUDENT",
        ]);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "hash" => $invitationLink->hash,
        ]);

        $this->assertTrue(is_numeric($createdUser->id));
    }

    /**
     * It should add a role to a user
     *
     * @return void
     */
    public function testShouldAddRoleToUser()
    {
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $user = factory(User::class)->create();

        $updatedRole = (new UpdateUserRoleService())->execute([
            "userId" => $user->id,
            "roleId" => $role->id,
        ]);

        $this->assertTrue(is_numeric($updatedRole->roles[0]->id));
    }

    /**
     * It should delete a role to a user
     *
     * @return void
     */
    public function testShouldDeleteRoleToUser()
    {
        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $user = factory(User::class)->create();

        $updatedRole = (new RemoveUserRoleService())->execute([
            "userId" => $user->id,
            "roleId" => $role->id,
        ]);

        $this->assertTrue(count($updatedRole->roles) < 1);
    }
}
