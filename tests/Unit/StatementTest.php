<?php

namespace Tests\Unit;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Services\Statement\CreateStatementService;

class StatementTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new statement
     *
     * @return void
     */
    public function testShouldCreateANewStatement()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $statement = (new CreateStatementService())->execute([
            "subject" => $this->faker->sentence(1),
            "statement" => $this->faker->sentence(2)
        ]);

        $this->assertTrue(is_numeric($statement->id));
    }
}
