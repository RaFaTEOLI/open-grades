<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Students Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin|teacher|responsible"]], function () {
        Route::get("/students", "API\StudentController@index")->middleware("permission:read-students");

        Route::get("/students/{id}", "API\StudentController@show")
            ->name("students.show")
            ->middleware("permission:read-students");

        Route::post("/students", "API\StudentController@store")
            ->name("students.store")
            ->middleware("permission:create-students");

        Route::put("/students/{id}", "API\StudentController@update")
            ->name("students.update")
            ->middleware("permission:update-students");

        Route::post("/student-responsible", "API\StudentsResponsibleController@link")
            ->name("students.responsible.link")
            ->middleware("permission:update-students");

        Route::delete(
            "/students/{studentId}/responsible/{responsibleId}",
            "API\StudentsResponsibleController@destroy",
        )->middleware("permission:delete-students");
    });
});
