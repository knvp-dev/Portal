<?php 

namespace App\Http\Middleware;

use Auth;
use Closure;

class Dm {

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->isDm() )
        {
            return $next($request);
        }

        return redirect('/');

    }

}