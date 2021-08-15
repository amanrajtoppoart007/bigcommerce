<?php

namespace App\Http\Controllers\Franchisee;

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
    protected $redirectTo = '/franchisee';

    public function __construct()
    {
        $this->middleware('guest:franchisee');
    }

    protected function guard()
    {
        return Auth::guard('franchisee');
    }

    protected function broker()
    {
        return Password::broker('franchisees');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('franchisee.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
