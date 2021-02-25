<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Configuration Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    Route::get("/configuration", "ConfigurationController@index")
        ->name("configuration")
        ->middleware("permission:read-configuration");

    Route::put("/configuration/{id}", "ConfigurationController@update")
        ->name("configuration.update")
        ->middleware("permission:update-configuration");
});
