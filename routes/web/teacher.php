<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
*/
Route::group(
    ["prefix" => "teacher", ["middleware" => ["role:admin"]], ["middleware" => ["role:teacher"]]],
    function () {
        Route::get("/teachers", "TeacherController@index")
            ->name("teachers")
            ->middleware("permission:read-teachers");

        Route::get("/teacher", function () {
            return view("teachers/teacher");
        })
            ->name("teachers.new")
            ->middleware("permission:read-teachers");

        Route::get("/teachers/{id}", "TeacherController@show")
            ->name("teachers.show")
            ->middleware("permission:read-teachers");

        Route::post("/teachers", "TeacherController@store")
            ->name("teachers.store")
            ->middleware("permission:create-teachers");

        Route::put("/teachers/{id}", "TeacherController@update")
            ->name("teachers.update")
            ->middleware("permission:update-teachers");

        Route::post("/teacherResponsible", "TeachersResponsibleController@link")
            ->name("teachers.responsible.link")
            ->middleware("permission:update-teachers");

        Route::delete("/teachers/{teacherId}/responsible/{responsibleId}", "TeachersResponsibleController@destroy")
            ->name("teachers.responsible.remove")
            ->middleware("permission:delete-teachers");
    },
);
