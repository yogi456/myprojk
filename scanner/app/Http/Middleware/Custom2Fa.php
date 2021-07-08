<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class Custom2Fa
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
        
        if(Auth::user()->is_2fa_active == 1 && Auth::user()->google2fa_secret !== ''){ 
             return app(\PragmaRX\Google2FALaravel\Middleware::class)->handle($request, $next);
        }
        return $next($request);
    }
}
