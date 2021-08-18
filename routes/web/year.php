<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin"]],
    function () {
        Route::get("/years", "YearController@index")
            ->name("years")
            ->middleware("permission:read-years");

        Route::get("/year", function () {
            return view("years/year");
        })
            ->name("years.new")
            ->middleware("permission:read-years");

        Route::get("/years/{id}", "YearController@show")
            ->name("years.show")
            ->middleware("permission:read-years");

        Route::post("/years", "YearController@store")
            ->name("years.store")
            ->middleware("permission:create-years");

        Route::put("/years/{id}", "YearController@update")
            ->name("years.update")
            ->middleware("permission:update-years");

        Route::delete("/years/{id}", "YearController@destroy")
            ->name("years.destroy")
            ->middleware("permission:delete-years");

        Route::patch("/years/{id}", "YearController@close")
            ->name("years.close")
            ->middleware("permission:update-years");
    },
);
