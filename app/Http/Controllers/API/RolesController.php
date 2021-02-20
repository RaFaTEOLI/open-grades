<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\HttpStatus;
use App\Http\Requests\Role\RoleRequest;
use App\Models\Role;
use App\Services\Role\CreateRoleService;
use App\Repositories\RolesRepository\RolesRepository;
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

        return response()->json($roles, HttpStatus::SUCCESS);
    }

    public function store(RoleRequest $request)
    {
        try {
            $input = $request->all();

            $createRoleService = new CreateRoleService();
            $role = $createRoleService->execute($input);

            return response()->json($role, HttpStatus::CREATED);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $role = $this->rolesRepository->findById($id);

        return response()->json($role, HttpStatus::SUCCESS);
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "display_name", "description"]);
        $role = $this->rolesRepository->update($id, $input);

        return response()->json($role, HttpStatus::SUCCESS);
    }

    public function destroy($id)
    {
        try {
            $this->rolesRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], HttpStatus::SERVER_ERROR);
        }
    }
}
