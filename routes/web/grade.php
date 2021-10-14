<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin|teacher"]],
    function () {
        Route::get("/grades", "GradeController@index")
            ->name("grades")
            ->middleware("permission:read-grades");

        Route::get("/grades/{id}", "GradeController@show")
            ->name("grades.show")
            ->middleware("permission:read-grades");
    },
);


Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin"]],
    function () {
        Route::get("/grade", function () {
            return view("grades/grade");
        })
            ->name("grades.new")
            ->middleware("permission:read-grades");

        Route::post("/grades", "GradeController@store")
            ->name("grades.store")
            ->middleware("permission:create-grades");

        Route::put("/grades/{id}", "GradeController@update")
            ->name("grades.update")
            ->middleware("permission:update-grades");

        Route::delete("/grades/{id}", "GradeController@destroy")
            ->name("grades.destroy")
            ->middleware("permission:delete-grades");
    },
);
