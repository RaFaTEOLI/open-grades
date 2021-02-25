<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Permissions Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/permissions", "API\PermissionController@index")
            ->name("permissions")
            ->middleware("permission:read-permissions");

        Route::get("/permission/{id}", "API\PermissionController@show")->middleware("permission:read-permissions");

        Route::delete("/permission/{id}", "API\PermissionController@destroy")->middleware(
            "permission:delete-permissions",
        );
        Route::post("/permissions", "API\PermissionController@store")->middleware("permission:create-permissions");

        Route::put("/permissions/{id}", "API\PermissionController@update")->middleware("permission:update-permissions");
    });
});
