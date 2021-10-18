<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Evaluation Type Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin|teacher"]], function () {
        Route::get("/evaluation-types", "API\EvaluationTypeController@index")->middleware("permission:read-evaluation-types");

        Route::get("/evaluation-types/{id}", "API\EvaluationTypeController@show")
            ->name("evaluation-types.show")
            ->middleware("permission:read-evaluation-types");
    });

    Route::group(["middleware" => ["role:admin"]], function () {
        Route::post("/evaluation-types", "API\EvaluationTypeController@store")
            ->name("evaluation-types.store")
            ->middleware("permission:create-evaluation-types");

        Route::put("/evaluation-types/{id}", "API\EvaluationTypeController@update")
            ->name("evaluation-types.update")
            ->middleware("permission:update-evaluation-types");

        Route::delete("/evaluation-types/{id}", "API\EvaluationTypeController@destroy")
            ->name("evaluation-types.destroy")
            ->middleware("permission:delete-evaluation-types");
    });
});
