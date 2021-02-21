<?php

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
    Route::get("/roles", "RolesController@index")->name("roles");
    Route::get("/role", function () {
        return view("admin/role/role");
    })->name("roles.new");
    Route::get("/role/{id}", "RolesController@show")->name("roles.show");
    Route::delete("/role/{id}", "RolesController@destroy")->name("roles.destroy");
    Route::post("/roles", "RolesController@store")->name("roles.store");
    Route::put("/roles/{id}", "RolesController@update")->name("roles.update");
    Route::patch("/roles/{roleId}/permission/{permissionId}", "RolesPermissionController@store")->name(
        "roles.permission.update",
    );
    Route::delete("/roles/{roleId}/permission/{permissionId}", "RolesPermissionController@destroy")->name(
        "roles.permission.remove",
    );
});
