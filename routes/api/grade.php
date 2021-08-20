<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Grades Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/grades", "API\GradeController@index")->middleware("permission:read-grades");

        Route::get("/grades/{id}", "API\GradeController@show")
            ->name("grades.show")
            ->middleware("permission:read-grades");

        Route::post("/grades", "API\GradeController@store")
            ->name("grades.store")
            ->middleware("permission:create-grades");

        Route::put("/grades/{id}", "API\GradeController@update")
            ->name("grades.update")
            ->middleware("permission:update-grades");

        Route::delete("/grades/{id}", "API\GradeController@destroy")
            ->name("grades.destroy")
            ->middleware("permission:delete-grades");
    });
});
