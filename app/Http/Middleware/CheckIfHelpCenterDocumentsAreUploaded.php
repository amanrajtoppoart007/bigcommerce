<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfHelpCenterDocumentsAreUploaded
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
        if(!is_null(auth()->user()->profile)){
            if(auth()->user()->profile->aadhaar_card && auth()->user()->profile->pan_card && auth()->user()->profile->address_proof){
                return $next($request);
            }
        }
        return redirect()->route('helpCenter.show.upload.documents.form');
    }
}
