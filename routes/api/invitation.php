<?php

/*
|--------------------------------------------------------------------------
| Invitation Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("invitations", "API\InvitationLinkController@index");
        Route::get("invitations/{id}", "API\InvitationLinkController@show");
        Route::post("invitations", "API\InvitationLinkController@store");
    });
});
