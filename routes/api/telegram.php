<?php

/*
|--------------------------------------------------------------------------
| Telegram Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::post("messages", "API\TelegramController@store");
        Route::get("messages", "API\TelegramController@index");
        Route::get("messages/{id}", "API\TelegramController@show");
    });
});
