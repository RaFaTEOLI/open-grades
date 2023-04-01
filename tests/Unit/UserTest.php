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
use Exception;

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

        $invitationLink = (new CreateInvitationLinkService())->execute([
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

    /**
     * It should not delete admin role from user because user is admin
     *
     * @return void
     */
    public function testShouldNotDeleteAdminRoleFromUserBecauseUserIsAdmin()
    {
        $this->expectException(Exception::class);

        $userAdmin = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);

        $this->actingAs($userAdmin);

        $adminMaster = User::find(1);

        (new RemoveUserRoleService())->execute([
            "userId" => $adminMaster->id,
            "roleId" => $role->id,
        ]);
    }

    /**
     * It should create a new user using STUDENT type
     *
     * @return void
     */
    public function testShouldCreateANewUserUsingStudentType()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "type" => "STUDENT",
        ]);

        $this->assertTrue(is_numeric($createdUser->id));
    }

    /**
     * It should create a new user using RESPONSIBLE type
     *
     * @return void
     */
    public function testShouldCreateANewUserUsingResponsibleType()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $createdUser = (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "type" => "RESPONSIBLE",
            "student_id" => $student->id
        ]);

        $this->assertTrue(is_numeric($createdUser->id));
    }

    /**
     * It should not create a new user because request is invalid
     *
     * @return void
     */
    public function testShouldNotCreateANewUserBecauseRequestIsInvalid()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);


        (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "hash" => $this->faker->text()
        ]);
    }

    /**
     * It should not add a role to a user because request is invalid
     *
     * @return void
     */
    public function testShouldNotAddRoleToUserBecauseRequestIsInvalid()
    {
        $this->expectException(Exception::class);
        $userAdmin = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $userAdmin->attachRole($role);
        $this->actingAs($userAdmin);

        (new UpdateUserRoleService())->execute([
            "userId" => $this->faker->text(),
            "roleId" => $this->faker->text(),
        ]);
    }

    /**
     * It should not create a new user using INVALID type
     *
     * @return void
     */
    public function testShouldNotCreateANewUserUsingInvalidType()
    {
        $this->expectException(Exception::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new CreateUserService())->execute([
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "password" => "12345678",
            "type" => "THIS_IS_AN_INVALID_TYPE",
        ]);
    }
}
