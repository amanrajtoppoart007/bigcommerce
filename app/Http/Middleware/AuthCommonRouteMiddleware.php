<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCommonRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->guard('admin')->check() || auth()->guard('help_center')->check()){
            return $next($request);
        }else{
            return back();
        }
    }
}
