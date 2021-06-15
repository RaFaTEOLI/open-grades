<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teachers Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"], ["middleware" => ["role:teacher"]]], function () {
        Route::get("/teachers", "API\TeacherController@index")->middleware("permission:read-teachers");

        Route::get("/teachers/{id}", "API\TeacherController@show")
            ->name("teachers.show")
            ->middleware("permission:read-teachers");

        Route::post("/teachers", "API\TeacherController@store")
            ->name("teachers.store")
            ->middleware("permission:create-teachers");

        Route::put("/teachers/{id}", "API\TeacherController@update")
            ->name("teachers.update")
            ->middleware("permission:update-teachers");

        Route::post("/studentResponsible", "API\TeachersResponsibleController@link")
            ->name("teachers.responsible.link")
            ->middleware("permission:update-teachers");

        Route::delete(
            "/teachers/{studentId}/responsible/{responsibleId}",
            "API\TeachersResponsibleController@destroy",
        )->middleware("permission:delete-teachers");
    });
});
