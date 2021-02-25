<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\PermissionRequest;
use App\Repositories\PermissionRepository\PermissionRepository;
use App\Services\Permission\CreatePermissionService;
use Illuminate\Http\Request;
use Exception;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->permissionRepository = new PermissionRepository();
    }

    public function index()
    {
        $permissions = $this->permissionRepository->all();

        return view("admin/permission/permissions", [
            "permissions" => $permissions,
        ]);
    }

    public function store(PermissionRequest $request)
    {
        try {
            $input = $request->all();

            $createPermissionService = new CreatePermissionService();
            $createPermissionService->execute($input);

            return redirect()
                ->route("permissions")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }

    public function show($id)
    {
        $permission = $this->permissionRepository->findById($id);

        return view("admin/permission/permission", ["permission" => $permission]);
    }

    public function update($id, Request $request)
    {
        $input = $request->only(["name", "display_name", "description"]);
        $this->permissionRepository->update($id, $input);

        return redirect()
            ->route("permissions")
            ->withSuccess(__("actions.success"));
    }

    public function destroy($id)
    {
        try {
            $this->permissionRepository->delete($id);

            return redirect()
                ->route("permissions")
                ->withSuccess(__("actions.success"));
        } catch (Exception $e) {
            return back()->with("error", __("actions.error"));
        }
    }
}
