<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class VerificationMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->verified) {
                auth()->logout();

                return redirect()->back()->with('message', trans('global.verifyYourEmail'));
            }
        }

        return $next($request);
    }
}
