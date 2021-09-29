<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Classes Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(
        ["prefix" => "student", ["middleware" => ["role:student"]]],
        function () {
            Route::get("/classes", "API\StudentClassController@index")
                ->middleware("permission:read-student-classes");

            Route::get("/classes/{id}", "API\StudentClassController@show")
                ->middleware("permission:read-student-classes");

            Route::post("/classes", "API\StudentClassController@store")
                ->middleware("permission:create-student-classes");

            Route::put("/classes/{id}", "API\StudentClassController@update")
                ->middleware("permission:update-student-classes");

            Route::delete("/classes/{id}", "API\StudentClassController@destroy")
                ->middleware("permission:delete-student-classes");
        },
    );
});


Route::group(["middleware" => "auth:api"], function () {
    Route::group(
        ["middleware" => ["role:admin|responsible"]],
        function () {
            Route::get("/student/{studentId}/classes", "API\StudentClassController@index")
                ->middleware("permission:read-student-classes");

            Route::get("/student/{studentId}/classes/{id}", "API\StudentClassController@show")
                ->middleware("permission:read-student-classes");

            Route::post("/student/{studentId}/classes", "API\StudentClassController@store")
                ->middleware("permission:create-student-classes");

            Route::put("/student/{studentId}/classes/{id}", "API\StudentClassController@update")
                ->middleware("permission:update-student-classes");

            Route::delete("/student/{studentId}/classes/{classId}", "API\StudentClassController@destroy")
                ->middleware("permission:delete-student-classes");
        },
    );
});
