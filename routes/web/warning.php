<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Warning Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "school"],
    function () {
        Route::get("/warnings", "WarningController@index")
            ->name("warnings")
            ->middleware("permission:read-warnings");

        Route::get("/warning", "WarningController@new")
            ->name("warnings.new")
            ->middleware("permission:read-warnings");

        Route::get("/warnings/{id}", "WarningController@show")
            ->name("warnings.show")
            ->middleware("permission:read-warnings");

        Route::post("/warning", "WarningController@store")
            ->name("warnings.store")
            ->middleware("permission:create-warnings");

        Route::put("/warnings/{id}", "WarningController@update")
            ->name("warnings.update")
            ->middleware("permission:update-warnings");

        Route::delete("/warnings/{id}", "WarningController@destroy")
            ->name("warnings.destroy")
            ->middleware("permission:delete-warnings");
    },
);
