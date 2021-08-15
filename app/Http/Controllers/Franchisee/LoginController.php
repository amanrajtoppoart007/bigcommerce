<?php

namespace App\Http\Controllers\Franchisee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:franchisee',['except'=>'logout']);

    }
    public function index()
    {
        return view("franchisee.auth.login");
    }

    public function login(Request $request)
    {
           $validator = Validator::make($request->all(),[
             'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!$validator->fails())
        {

            if (Auth::guard('franchisee')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->input('remember'))) {
                return redirect()->intended(route('franchisee.dashboard'));
            }
            else
            {
                return redirect()->back()->with('message','Invalid credentials')->withInput($request->only('email', 'remember'));
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only('email', 'remember'));
        }
    }

    public function logout()
    {
        Auth::guard('franchisee')->logout();
        return redirect()->route('franchisee.login');
    }
}
