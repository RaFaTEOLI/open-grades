<?php

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
    Route::get("/configuration", "ConfigurationController@index")->name("configuration");
    Route::put("/configuration/{id}", "ConfigurationController@update")->name("configuration.update");
});
