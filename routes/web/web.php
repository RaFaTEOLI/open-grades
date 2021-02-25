<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get("lang/{locale}", "LocalizationController@index");
