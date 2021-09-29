<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Class Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "school", ["middleware" => ["role:admin|teacher|student"]]],
    function () {
        Route::get("/classes", "ClassController@index")
            ->name("classes")
            ->middleware("permission:read-classes");

        Route::get("/classes/{id}", "ClassController@show")
            ->name("classes.show")
            ->middleware("permission:read-classes");
    },
);


Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin"]],
    function () {

        Route::get("/class", "ClassController@new")
            ->name("classes.new")
            ->middleware("permission:read-classes");

        Route::post("/classes", "ClassController@store")
            ->name("classes.store")
            ->middleware("permission:create-classes");

        Route::put("/classes/{id}", "ClassController@update")
            ->name("classes.update")
            ->middleware("permission:update-classes");

        Route::delete("/classes/{id}", "ClassController@destroy")
            ->name("classes.destroy")
            ->middleware("permission:delete-classes");
    },
);
