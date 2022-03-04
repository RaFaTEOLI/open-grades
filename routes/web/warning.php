<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Warning Routes
|--------------------------------------------------------------------------
|
*/

Route::get("/warnings", "WarningController@index")
    ->name("warnings")
    ->middleware("permission:read-warnings");

Route::get("/warnings", "WarningController@new")
    ->name("warning.new")
    ->middleware("permission:read-warnings");

Route::post("/warning", "WarningController@store")
    ->name("warnings.store")
    ->middleware("permission:create-warnings");

Route::put("/warnings/{id}", "WarningController@update")
    ->name("warnings.update")
    ->middleware("permission:update-warnings");

Route::delete("/warnings/{id}", "WarningController@destroy")
    ->name("warnings.destroy")
    ->middleware("permission:delete-warnings");
