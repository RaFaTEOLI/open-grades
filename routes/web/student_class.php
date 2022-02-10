<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Classes Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "student", ["middleware" => ["role:student"]]],
    function () {
        Route::get("/classes", "StudentClassController@index")
            ->name("student.classes")
            ->middleware("permission:read-student-classes");

        Route::get("/classes/{id}", "StudentClassController@show")
            ->name("student.classes.show")
            ->middleware("permission:read-student-classes");

        Route::post("/classes", "StudentClassController@store")
            ->name("student.classes.store")
            ->middleware("permission:create-student-classes");

        Route::put("/classes/{id}", "StudentClassController@update")
            ->name("student.classes.update")
            ->middleware("permission:update-student-classes");

        Route::delete("/classes/{id}", "StudentClassController@destroy")
            ->name("student.classes.destroy")
            ->middleware("permission:delete-student-classes");
    },
);

Route::group(
    ["prefix" => "school", ["middleware" => ["role:admin|responsible|teacher"]]],
    function () {
        Route::get("/student/{studentId}/classes/{id}", "StudentClassController@show")
            ->name("responsible.student.classes.show")
            ->middleware("permission:read-student-classes");
    },
);

Route::group(
    ["prefix" => "school", ["middleware" => ["role:admin|responsible"]]],
    function () {
        Route::get("/student/{studentId}/classes", "StudentClassController@index")
            ->name("responsible.student.classes")
            ->middleware("permission:read-student-classes");

        Route::post("/student/{studentId}/classes", "StudentClassController@store")
            ->name("responsible.student.classes.store")
            ->middleware("permission:create-student-classes");

        Route::put("/student/{studentId}/classes/{id}", "StudentClassController@update")
            ->name("responsible.student.classes.update")
            ->middleware("permission:update-student-classes");

        Route::delete("/student/{studentId}/classes/{classId}", "StudentClassController@destroy")
            ->name("responsible.student.classes.destroy")
            ->middleware("permission:delete-student-classes");
    },
);
