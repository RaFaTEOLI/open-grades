<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\RolesRepository\RolesRepository;
use App\Services\Role\CreateRoleService;
use Exception;
use App\Models\Role;

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

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Role::validationRules());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

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

    public function show($id)
    {
        $role = $this->rolesRepository->findById($id);

        return view("admin/role/role", ["role" => $role]);
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "display_name", "description"]);
        $this->rolesRepository->update($id, $input);

        return redirect()
            ->route("roles")
            ->withSuccess(__("actions.success"));
    }

    public function destroy($id)
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
