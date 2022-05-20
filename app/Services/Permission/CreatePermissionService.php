<?php

namespace App\Services\Permission;

use Exception;
use App\Models\Permission;

class CreatePermissionService
{
    public function execute(array $request): bool
    {
        $actions = ["create", "read", "update", "delete"];

        try {
            if (empty($request)) {
                throw new Exception('Invalid Request');
            }
            foreach ($actions as $action) {
                if (isset($request[$action])) {
                    Permission::create([
                        "name" => $action . "-" . strtolower($request["name"]),
                        "display_name" => ucfirst($action) . " " . ucfirst($request["name"]),
                        "description" => ucfirst($action) . " " . ucfirst($request["description"]),
                    ]);
                }
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
