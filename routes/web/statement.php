<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Statement Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin"]],
    function () {
        Route::get("/statements", "StatementController@index")
            ->name("statements")
            ->middleware("permission:read-statements");

        Route::get("/statement", "StatementController@new")
            ->name("statements.new")
            ->middleware("permission:read-statements");

        Route::get("/statements/{id}", "StatementController@show")
            ->name("statements.show")
            ->middleware("permission:read-statements");

        Route::post("/statement", "StatementController@store")
            ->name("statements.store")
            ->middleware("permission:create-statements");

        Route::put("/statements/{id}", "StatementController@update")
            ->name("statements.update")
            ->middleware("permission:update-statements");

        Route::delete("/statements/{id}", "StatementController@destroy")
            ->name("statements.destroy")
            ->middleware("permission:delete-statements");
    },
);
