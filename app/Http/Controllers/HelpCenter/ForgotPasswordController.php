<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:help_center');
    }

    protected function broker()
    {
        return Password::broker('help_centers');
    }

    public function showLinkRequestForm()
    {
        return view('helpCenter.auth.passwords.email');
    }
}
