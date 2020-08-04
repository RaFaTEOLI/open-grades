<?php

namespace App\Http\Middleware;

use Closure;
use App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } else {
            $lang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            $acceptedLang = ['en', 'pt', 'pt-br']; 
            $lang = in_array($lang, $acceptedLang) ? $lang : 'en';
            App::setLocale($lang);
        }
        return $next($request);
    }
}
