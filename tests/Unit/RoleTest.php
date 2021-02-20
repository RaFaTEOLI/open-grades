<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should add a permission to a role
     *
     * @return void
     */
    public function testShouldAddPermissionToRole()
    {
        $this->assertTrue(true);
    }
}
