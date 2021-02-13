<?php

namespace App\Services\Role;

use Exception;
use App\Models\Role;

class CreateRoleService
{
    public function execute(array $request)
    {
        try {
            Role::create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
