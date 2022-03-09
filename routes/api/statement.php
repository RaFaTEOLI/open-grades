<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Warning Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/statements", "API\StatementController@index")->middleware("permission:read-statements");

        Route::get("/statements/{id}", "API\StatementController@show")
            ->name("statements.show")
            ->middleware("permission:read-statements");

        Route::post("/statements", "API\StatementController@store")
            ->name("statements.store")
            ->middleware("permission:create-statements");

        Route::patch("/statements/{id}", "API\StatementController@update")
            ->name("statements.update")
            ->middleware("permission:update-statements");

        Route::delete("/statements/{id}", "API\StatementController@destroy")
            ->name("statements.destroy")
            ->middleware("permission:delete-statements");
    });
});
