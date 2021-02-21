<?php

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
    Route::get("/invitations", "InvitationLinkController@index")->name("invitations");
    Route::get("/invitation", function () {
        return view("admin/invitation/invitation");
    })->name("invitations.new");
    Route::get("/invitation/{id}", "InvitationLinkController@show")->name("invitations.show");
    Route::delete("/invitation/{id}", "InvitationLinkController@destroy")->name("invitations.destroy");
    Route::post("/invitations", "InvitationLinkController@store")->name("invitations");
});
