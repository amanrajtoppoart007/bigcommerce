<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfHelpCenterHasActiveMembershipPlan
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
        $membership = auth()->user()->memberships()->latest()->first();
        if(!is_null($membership)){
            if(!($membership->membership_status == 'INACTIVE') && ($membership->membership_status == 'ACTIVE' && $membership->expiry_date >= date('Y-m-d'))){
                return $next($request);
            }
        }
        return redirect()->route('helpCenter.show.membership.payment.form');
    }
}
