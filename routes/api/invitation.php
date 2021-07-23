<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invitation Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:api"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("invitations", "API\InvitationLinkController@index")->middleware("permission:read-invitation");

        Route::get("invitations/{id}", "API\InvitationLinkController@show")->middleware("permission:read-invitation");

        Route::post("invitations", "API\InvitationLinkController@store")->middleware("permission:create-invitation");

        Route::delete("invitations/{id}", "API\InvitationLinkController@destroy")->middleware("permission:delete-invitation");
    });
});
