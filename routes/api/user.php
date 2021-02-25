<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("users/{id}", "API\UserController@show")->middleware("permission:read-users");

        Route::get("users", "API\UserController@all")->middleware("permission:read-users");

        Route::delete("/user/{id}", "API\UserController@destroy")->middleware("permission:delete-users");

        Route::post("/users", "API\UserController@store")->middleware("permission:create-users");

        Route::put("users/{id}", "API\UserController@update")->middleware("permission:update-users");

        Route::patch("/users/{userId}/role/{roleId}", "API\UsersRoleController@store")->middleware(
            "permission:update-users",
        );
        Route::delete("/users/{userId}/role/{roleId}", "API\UsersRoleController@destroy")->middleware(
            "permission:update-users",
        );
    });
});
