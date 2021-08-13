<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Subjects Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"], ["middleware" => ["role:admin"]]], function () {
        Route::get("/subjects", "API\SubjectController@index")->middleware("permission:read-subjects");

        Route::get("/subjects/{id}", "API\SubjectController@show")
            ->name("subjects.show")
            ->middleware("permission:read-subjects");

        Route::post("/subjects", "API\SubjectController@store")
            ->name("subjects.store")
            ->middleware("permission:create-subjects");

        Route::put("/subjects/{id}", "API\SubjectController@update")
            ->name("subjects.update")
            ->middleware("permission:update-subjects");

        Route::delete("/subjects/{id}", "API\SubjectController@destroy")
            ->name("subjects.destroy")
            ->middleware("permission:delete-subjects");
    });
});
