<?php

/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/roles", "API\RolesController@index");
        Route::get("/role/{id}", "API\RolesController@show");
        Route::delete("/role/{id}", "API\RolesController@destroy");
        Route::post("/roles", "API\RolesController@store");
        Route::put("/roles/{id}", "API\RolesController@update");
        Route::patch("/roles/{roleId}/permission/{permissionId}", "API\RolesPermissionController@store");
        Route::delete("/roles/{roleId}/permission/{permissionId}", "API\RolesPermissionController@destroy");
    });
});
