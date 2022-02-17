<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Evaluation Types Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin|teacher"]],
    function () {
        Route::get("/evaluation-types", "EvaluationTypeController@index")
            ->name("evaluation-types")
            ->middleware("permission:read-evaluation-types");

        Route::get("/evaluation-types/{id}", "EvaluationTypeController@show")
            ->name("evaluation-types.show")
            ->middleware("permission:read-evaluation-types");
    },
);


Route::group(
    ["prefix" => "admin", "middleware" => ["role:admin"]],
    function () {
        Route::get("/evaluation-type", function () {
            return view("evaluation_types/evaluation_type");
        })
            ->name("evaluation-types.new")
            ->middleware("permission:read-evaluation-types");

        Route::post("/evaluation-types", "EvaluationTypeController@store")
            ->name("evaluation-types.store")
            ->middleware("permission:create-evaluation-types");

        Route::put("/evaluation-types/{id}", "EvaluationTypeController@update")
            ->name("evaluation-types.update")
            ->middleware("permission:update-evaluation-types");

        Route::delete("/evaluation-types/{id}", "EvaluationTypeController@destroy")
            ->name("evaluation-types.destroy")
            ->middleware("permission:delete-evaluation-types");
    },
);
