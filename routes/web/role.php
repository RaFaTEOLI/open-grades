<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    Route::get("/roles", "RolesController@index")
        ->name("roles")
        ->middleware("permission:read-roles");

    Route::get("/role", function () {
        return view("admin/role/role");
    })->name("roles.new");

    Route::get("/role/{id}", "RolesController@show")
        ->name("roles.show")
        ->middleware("permission:read-roles");

    Route::delete("/role/{id}", "RolesController@destroy")
        ->name("roles.destroy")
        ->middleware("permission:delete-roles");

    Route::post("/roles", "RolesController@store")
        ->name("roles.store")
        ->middleware("permission:create-roles");

    Route::put("/roles/{id}", "RolesController@update")
        ->name("roles.update")
        ->middleware("permission:update-roles");

    Route::patch("/roles/{roleId}/permission/{permissionId}", "RolesPermissionController@store")
        ->name("roles.permission.update")
        ->middleware("permission:update-roles");

    Route::delete("/roles/{roleId}/permission/{permissionId}", "RolesPermissionController@destroy")
        ->name("roles.permission.remove")
        ->middleware("permission:delete-roles");
});
