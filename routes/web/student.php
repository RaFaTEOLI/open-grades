<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| students Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "student", ["middleware" => ["role:admin"]]], function () {
    Route::get("/students", "StudentController@index")
        ->name("students")
        ->middleware("permission:read-students");

    Route::patch("/students/{studentId}/permission/{permissionId}", "StudentsResponsibleController@store")
        ->name("students.permission.update")
        ->middleware("permission:update-students");

    Route::delete("/students/{studentId}/permission/{permissionId}", "StudentsResponsibleController@destroy")
        ->name("students.permission.remove")
        ->middleware("permission:delete-students");
});
