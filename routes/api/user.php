<?php

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("users/{id}", "API\UserController@show");
        Route::get("users", "API\UserController@all");
        Route::delete("/user/{id}", "API\UserController@destroy");
        Route::post("/users", "API\UserController@store");
        Route::put("users/{id}", "API\UserController@update");
        Route::patch("/users/{userId}/role/{roleId}", "API\UsersRoleController@store");
        Route::delete("/users/{userId}/role/{roleId}", "API\UsersRoleController@destroy");
    });
});
