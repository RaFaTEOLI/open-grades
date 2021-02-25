<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invitation Routes
|--------------------------------------------------------------------------
|
*/
/**
 * Admin Middleware
 */
Route::group(["prefix" => "admin", "middleware" => ["role:admin"]], function () {
    Route::get("/invitations", "InvitationLinkController@index")
        ->name("invitations")
        ->middleware("permission:read-invitation");

    Route::get("/invitation", function () {
        return view("admin/invitation/invitation");
    })
        ->name("invitations.new")
        ->middleware("permission:create-invitation");

    Route::get("/invitation/{id}", "InvitationLinkController@show")
        ->name("invitations.show")
        ->middleware("permission:read-invitation");

    Route::delete("/invitation/{id}", "InvitationLinkController@destroy")
        ->name("invitations.destroy")
        ->middleware("permission:delete-invitation");

    Route::post("/invitations", "InvitationLinkController@store")
        ->name("invitations")
        ->middleware("permission:create-invitation");
});
