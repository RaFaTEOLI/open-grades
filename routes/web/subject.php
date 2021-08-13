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
        Route::get("/subjects", "SubjectController@index")
            ->name("subjects")
            ->middleware("permission:read-subjects");

        Route::get("/subject", function () {
            return view("subjects/subject");
        })
            ->name("subjects.new")
            ->middleware("permission:read-subjects");

        Route::get("/subjects/{id}", "SubjectController@show")
            ->name("subjects.show")
            ->middleware("permission:read-subjects");

        Route::post("/subjects", "SubjectController@store")
            ->name("subjects.store")
            ->middleware("permission:create-subjects");

        Route::put("/subjects/{id}", "SubjectController@update")
            ->name("subjects.update")
            ->middleware("permission:update-subjects");

        Route::delete("/subjects/{id}", "SubjectController@destroy")
            ->name("subjects.destroy")
            ->middleware("permission:delete-subjects");
    },
);
