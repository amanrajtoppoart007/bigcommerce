<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/help-center';

    public function __construct()
    {
        $this->middleware('guest:help_center');
    }

    protected function guard()
    {
        return Auth::guard('help_center');
    }

    protected function broker()
    {
        return Password::broker('help_centers');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('helpCenter.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
