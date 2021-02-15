<?php

use Illuminate\Http\Request;

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

    Route::group(["middleware" => ["role:admin"]], function () {
        /**
         * User Routes
         */
        Route::get("users/{id}", "API\UserController@show");
        Route::get("users", "API\UserController@all");
        Route::delete("/user/{id}", "API\UserController@destroy");
        Route::post("/users", "API\UserController@store");
        Route::put("users/{id}", "API\UserController@update");
        Route::patch("/users/{userId}/role/{roleId}", "API\UsersRoleController@store");
        Route::delete("/users/{userId}/role/{roleId}", "API\UsersRoleController@destroy");

        /**
         * Roles Routes
         */
        Route::get("/roles", "API\RolesController@index");
        Route::get("/role/{id}", "API\RolesController@show");
        Route::delete("/role/{id}", "API\RolesController@destroy");
        Route::post("/roles", "API\RolesController@store");
        Route::put("/roles/{id}", "API\RolesController@update");

        Route::get("invitations", "API\InvitationLinkController@index");
        Route::get("invitations/{id}", "API\InvitationLinkController@show");
        Route::post("invitations", "API\InvitationLinkController@store");

        Route::get("configurations", "API\ConfigurationController@index");
        Route::get("configurations/{id}", "API\ConfigurationController@show");
        Route::post("configurations", "API\ConfigurationController@store");
        Route::put("configurations/{id}", "API\ConfigurationController@update");
        Route::delete("configurations/{id}", "API\ConfigurationController@destroy");

        Route::post("messages", "API\TelegramController@store");
        Route::get("messages", "API\TelegramController@index");
        Route::get("messages/{id}", "API\TelegramController@show");
    });
});
