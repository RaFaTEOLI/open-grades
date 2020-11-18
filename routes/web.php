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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Informative Routes
 */
Route::get('/permission', function () {
    return view('informative/permission');
})->name('permission');

/**
 * Invitations
 */
Route::get('/invitations', 'InvitationLinkController@index')->name('invitations');
Route::get('/invitation', function () {
    return view('admin/invitation');
})->name('invitations.new');
Route::get('/invitation/{id}', 'InvitationLinkController@show')->name('invitations.show');
Route::delete('/invitation/{id}', 'InvitationLinkController@destroy')->name('invitations.destroy');
Route::post('/invitations', 'InvitationLinkController@store')->name('invitations');

/**
 * Configuration
 */
Route::get('/configuration', 'ConfigurationController@index')->name('configuration');
Route::put('/configuration/{id}', 'ConfigurationController@update')->name('configuration.update');

Route::get('lang/{locale}', 'LocalizationController@index');
