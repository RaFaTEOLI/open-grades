<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("login", "API\UserController@login");
Route::post("register", "API\UserController@register");

Route::group(["middleware" => "auth:api"], function () {
    Route::get("details", "API\UserController@details");
    Route::get("logout", "API\UserController@logout");
});

Route::get("/health", "API\APIController@health");
Route::get("/version", "API\APIController@version");
Route::get("/metrics", "API\APIController@metrics");

Route::fallback(function () {
    return response()->json(["error" => "Page Not Found"], 404);
});
