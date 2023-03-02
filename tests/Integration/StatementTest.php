<?php

namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\HttpStatus;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Statement;

class StatementTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should create a new Statement
     *
     * @return void
     */
    public function testShouldCreateANewStatement()
    {
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $response = $this->actingAs($user, "api")->json("POST", env("APP_API") . "/statements", [
            "subject" => $this->faker->sentence(1),
            "statement" => $this->faker->sentence(2)
        ]);

        $response->assertStatus(HttpStatus::CREATED);
    }

    /**
     * It should list all Statements
     *
     * @return void
     */
    public function testShouldListAllStatements()
    {
        $user = User::find(1);
        Auth::login($user);
        factory(Statement::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/statements");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([['id', 'subject', 'statement']]);
    }

    /**
     * It should show a Statement by id
     *
     * @return void
     */
    public function testShouldShowAStatementById()
    {
        $user = User::find(1);
        Auth::login($user);

        $statement = factory(Statement::class)->create();

        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/statements/{$statement->id}");

        $response
            ->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure(['id', 'subject', 'statement']);
    }

    /**
     * It should delete a Statement by id
     *
     * @return void
     */
    public function testShouldDeleteAStatementById()
    {
        $user = User::find(1);
        Auth::login($user);

        $statement = factory(Statement::class)->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', env('APP_API') . "/statements/{$statement->id}");
        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should update a Statement
     *
     * @return void
     */
    public function testShouldUpdateStatement()
    {
        $user = User::find(1);
        Auth::login($user);

        $statement = factory(Statement::class)->create();

        $response = $this->actingAs($user, "api")->json("PATCH", env("APP_API") . "/statements/{$statement->id}", [
            "subject" => $this->faker->sentence(1),
            "statement" => $this->faker->sentence(2)
        ]);

        $response->assertStatus(HttpStatus::NO_CONTENT);
    }

    /**
     * It should return the list of Classes with limit and offset
     *
     * @return void
     */
    public function testShouldFetchListOfClasssWithLimitAndOffset()
    {
        $user = User::find(1);
        Auth::login($user);

        factory(Statement::class)->create();
        factory(Statement::class)->create();
        $response = $this->actingAs($user, "api")->json("GET", env("APP_API") . "/statements?offset=0&limit=1");

        $response->assertStatus(HttpStatus::SUCCESS);
        $this->assertTrue(count($response->original) == 1);
    }
}
