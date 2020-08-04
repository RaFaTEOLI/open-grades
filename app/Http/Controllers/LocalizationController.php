<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index($locale)
    {
        App::setLocale($locale);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale);
        return redirect()->back();
    }
}