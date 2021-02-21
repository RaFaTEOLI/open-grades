<?php

/*
|--------------------------------------------------------------------------
| Configuration Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("configurations", "API\ConfigurationController@index");
        Route::get("configurations/{id}", "API\ConfigurationController@show");
        Route::post("configurations", "API\ConfigurationController@store");
        Route::put("configurations/{id}", "API\ConfigurationController@update");
        Route::delete("configurations/{id}", "API\ConfigurationController@destroy");
    });
});
