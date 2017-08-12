<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use DB;

class Language
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
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            $defaultLang = DB::table('languages')
							->select('*')
							->where('is_deleted', '0')
							->where('is_default', '1')
							->first();
				if(isset($defaultLang->code) && $defaultLang->code != ""){
					$locale = $defaultLang->code;
				}
				else {
					$locale = 'en';
				}
				session(['locale'=>$locale]);			
        }

        App::setLocale($locale);

        return $next($request);
    }
}
