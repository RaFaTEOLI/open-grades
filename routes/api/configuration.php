<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Configuration Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("configurations", "API\ConfigurationController@index")->middleware("permission:read-configuration");

        Route::get("configurations/{id}", "API\ConfigurationController@show")->middleware(
            "permission:read-configuration",
        );

        Route::post("configurations", "API\ConfigurationController@store")->middleware(
            "permission:create-configuration",
        );

        Route::put("configurations/{id}", "API\ConfigurationController@update")->middleware(
            "permission:update-configuration",
        );

        Route::delete("configurations/{id}", "API\ConfigurationController@destroy")->middleware(
            "permission:delete-configuration",
        );
    });
});
