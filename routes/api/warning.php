<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Warning Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::get("/warnings", "API\WarningController@index")->middleware("permission:read-warnings");

    Route::get("/warnings/{id}", "API\WarningController@show")
        ->name("warnings.show")
        ->middleware("permission:read-warnings");

    Route::post("/warnings", "API\WarningController@store")
        ->name("warnings.store")
        ->middleware("permission:create-warnings");

    Route::patch("/warnings/{id}", "API\WarningController@update")
        ->name("warnings.update")
        ->middleware("permission:update-warnings");

    Route::delete("/warnings/{id}", "API\WarningController@destroy")
        ->name("warnings.destroy")
        ->middleware("permission:delete-warnings");
});
