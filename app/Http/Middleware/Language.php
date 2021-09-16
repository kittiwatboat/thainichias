<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Session;

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

        
        $language = Session('lang'); 
        if($language=="")
        {
            Session::put('lang','th'); 
            $language = Session('lang');
            App::setLocale($language);
        }
        else
        { 
            //&& in_array($language, Config::get('app.locale'))
            // set from Session
            // App::setLocale($language); 

            // set from url
            $uri = $request->url(); 
            $uri_lang = $request->segment(1);
            Session::put('lang',$uri_lang); 
            App::setLocale($uri_lang);
         
        }
        return $next($request);
    }
}
