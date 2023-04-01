<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Classes Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/classes", "API\ClassController@index")->middleware("permission:read-classes");

        Route::get("/classes/{id}", "API\ClassController@show")
            ->name("classes.show")
            ->middleware("permission:read-classes");

        Route::get("/classes/{id}/students", "API\ClassStudentsController@show")
            ->name("classes.show.students")
            ->middleware("permission:read-classes");

        Route::post("/classes", "API\ClassController@store")
            ->name("classes.store")
            ->middleware("permission:create-classes");

        Route::put("/classes/{id}", "API\ClassController@update")
            ->name("classes.update")
            ->middleware("permission:update-classes");

        Route::delete("/classes/{id}", "API\ClassController@destroy")
            ->name("classes.destroy")
            ->middleware("permission:delete-classes");
    });
});
