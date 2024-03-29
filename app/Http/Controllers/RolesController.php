<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleRequest;
use App\Repositories\Permission\PermissionRepository;
use Illuminate\Http\Request;
use App\Repositories\Roles\RolesRepository;
use App\Services\Role\CreateRoleService;
use Exception;

class RolesController extends Controller
{
    private $rolesRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->rolesRepository = new RolesRepository();
    }

    public function index()
    {
        $roles = $this->rolesRepository->all();

        return view("admin/role/roles", [
            "roles" => $roles,
        ]);
    }

    public function store(RoleRequest $request)
    {
        try {
            $input = $request->all();

            $createRoleService = new CreateRoleService();
            $createRoleService->execute($input);

            return redirect()
                ->route("roles")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show(int $id)
    {
        $role = $this->rolesRepository->findById($id);
        $permissions = (new PermissionRepository())->findPermissionsNotInRole($id);

        return view("admin/role/role", ["role" => $role, "permissions" => $permissions]);
    }

    public function update(int $id, Request $request)
    {
        try {
            $input = $request->only(["name", "display_name", "description"]);
            $this->rolesRepository->update($id, $input);

            return redirect()
                ->route("roles")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->rolesRepository->delete($id);

            return redirect()
                ->route("roles")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
