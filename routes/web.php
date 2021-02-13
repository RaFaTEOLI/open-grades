<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("welcome");
});

Auth::routes(["verify" => true]);

Route::get("/home", "HomeController@index")->name("home");

/**
 * Informative Routes
 */
Route::get("/401", function () {
    return view("informative/401");
})->name("401");

Route::get("/403", function () {
    return view("informative/403");
})->name("403");

/**
 * Admin Middleware
 */

Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    /**
     * User Routes
     */
    Route::get("/users", "UserController@index")->name("users");
    Route::get("/user", function () {
        return view("admin/user/user");
    })->name("users.new");
    Route::get("/user/{id}", "UserController@show")->name("users.show");
    Route::delete("/user/{id}", "UserController@destroy")->name("users.destroy");
    Route::post("/users", "UserController@store")->name("users.store");
    Route::put("/users/{id}", "UserController@update")->name("users.update");
    Route::patch("/users/{userId}/role/{roleId}", "UsersRoleController@store")->name("users.role");
    Route::delete("/users/{userId}/role/{roleId}", "UsersRoleController@destroy")->name("users.role.remove");

    /**
     * Roles Routes
     */
    Route::get("/roles", "RolesController@index")->name("roles");
    Route::get("/role", function () {
        return view("admin/role/role");
    })->name("roles.new");
    Route::get("/role/{id}", "RolesController@show")->name("roles.show");
    Route::delete("/role/{id}", "RolesController@destroy")->name("roles.destroy");
    Route::post("/roles", "RolesController@store")->name("roles.store");
    Route::put("/roles/{id}", "RolesController@update")->name("roles.update");

    /**
     * Invitations
     */
    Route::get("/invitations", "InvitationLinkController@index")->name("invitations");
    Route::get("/invitation", function () {
        return view("admin/invitation/invitation");
    })->name("invitations.new");
    Route::get("/invitation/{id}", "InvitationLinkController@show")->name("invitations.show");
    Route::delete("/invitation/{id}", "InvitationLinkController@destroy")->name("invitations.destroy");
    Route::post("/invitations", "InvitationLinkController@store")->name("invitations");

    /**
     * Configuration
     */
    Route::get("/configuration", "ConfigurationController@index")->name("configuration");
    Route::put("/configuration/{id}", "ConfigurationController@update")->name("configuration.update");
});
Route::get("lang/{locale}", "LocalizationController@index");
