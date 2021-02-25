<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    Route::get("/users", "UserController@index")
        ->name("users")
        ->middleware("permission:read-users");

    Route::get("/user", function () {
        return view("admin/user/user");
    })
        ->name("users.new")
        ->middleware("permission:read-users");

    Route::get("/user/{id}", "UserController@show")
        ->name("users.show")
        ->middleware("permission:read-users");

    Route::delete("/user/{id}", "UserController@destroy")
        ->name("users.destroy")
        ->middleware("permission:delete-users");

    Route::post("/users", "UserController@store")
        ->name("users.store")
        ->middleware("permission:create-users");

    Route::put("/users/{id}", "UserController@update")
        ->name("users.update")
        ->middleware("permission:update-users");

    Route::patch("/users/{userId}/role/{roleId}", "UsersRoleController@store")
        ->name("users.role")
        ->middleware("permission:update-users");

    Route::delete("/users/{userId}/role/{roleId}", "UsersRoleController@destroy")
        ->name("users.role.remove")
        ->middleware("permission:update-users");
});
