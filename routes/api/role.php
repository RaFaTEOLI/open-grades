<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/roles", "API\RolesController@index")->middleware("permission:read-roles");

        Route::get("/roles/{id}", "API\RolesController@show")->middleware("permission:read-roles");

        Route::delete("/roles/{id}", "API\RolesController@destroy")->middleware("permission:delete-roles");

        Route::post("/roles", "API\RolesController@store")->middleware("permission:create-roles");

        Route::put("/roles/{id}", "API\RolesController@update")->middleware("permission:update-roles");

        Route::patch("/roles/{roleId}/permission/{permissionId}", "API\RolesPermissionController@store")->middleware(
            "permission:update-roles",
        );

        Route::delete("/roles/{roleId}/permission/{permissionId}", "API\RolesPermissionController@destroy")->middleware(
            "permission:delete-roles",
        );
    });
});
