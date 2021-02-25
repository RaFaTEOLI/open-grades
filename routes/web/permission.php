<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Permissions Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    Route::get("/permissions", "PermissionController@index")
        ->name("permissions")
        ->middleware("permission:read-permissions");

    Route::get("/permission", function () {
        return view("admin/permission/permission");
    })
        ->name("permissions.new")
        ->middleware("permission:create-permissions");

    Route::get("/permission/{id}", "PermissionController@show")
        ->name("permissions.show")
        ->middleware("permission:create-permissions");

    Route::delete("/permission/{id}", "PermissionController@destroy")
        ->name("permissions.destroy")
        ->middleware("permission:delete-permissions");

    Route::post("/permissions", "PermissionController@store")
        ->name("permissions.store")
        ->middleware("permission:create-permissions");

    Route::put("/permissions/{id}", "PermissionController@update")
        ->name("permissions.update")
        ->middleware("permission:update-permissions");
});
