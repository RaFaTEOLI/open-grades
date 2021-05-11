<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| students Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"], ["middleware" => ["role:teacher"]]], function () {
        Route::get("/students", "API\StudentController@index")->middleware("permission:read-students");

        Route::patch(
            "/students/{studentId}/permission/{permissionId}",
            "API\StudentsResponsibleController@store",
        )->middleware("permission:update-students");

        Route::delete(
            "/students/{studentId}/permission/{permissionId}",
            "API\StudentsResponsibleController@destroy",
        )->middleware("permission:delete-students");
    });
});
