<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| students Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "school", "middleware" => ["role:admin|teacher|responsible"]],
    function () {
        Route::get("/students", "StudentController@index")
            ->name("students")
            ->middleware("permission:read-students");

        Route::get("/student", function () {
            return view("students/student");
        })
            ->name("students.new")
            ->middleware("permission:read-students");

        Route::get("/students/{id}", "StudentController@show")
            ->name("students.show")
            ->middleware("permission:read-students");

        Route::post("/students", "StudentController@store")
            ->name("students.store")
            ->middleware("permission:create-students");

        Route::put("/students/{id}", "StudentController@update")
            ->name("students.update")
            ->middleware("permission:update-students");

        Route::post("/student-responsible", "StudentsResponsibleController@link")
            ->name("students.responsible.link")
            ->middleware("permission:update-students");

        Route::delete("/students/{studentId}/responsible/{responsibleId}", "StudentsResponsibleController@destroy")
            ->name("students.responsible.remove")
            ->middleware("permission:delete-students");
    },
);
