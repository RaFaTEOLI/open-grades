<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| years Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/years", "API\YearController@index")->middleware("permission:read-years");

        Route::get("/years/{id}", "API\YearController@show")
            ->name("years.show")
            ->middleware("permission:read-years");

        Route::post("/years", "API\YearController@store")
            ->name("years.store")
            ->middleware("permission:create-years");

        Route::put("/years/{id}", "API\YearController@update")
            ->name("years.update")
            ->middleware("permission:update-years");

        Route::delete("/years/{id}", "API\YearController@destroy")
            ->name("years.destroy")
            ->middleware("permission:delete-years");
    });
});
