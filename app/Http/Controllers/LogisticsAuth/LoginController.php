<?php

namespace App\Http\Controllers\LogisticsAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest:logistics',['except'=>'logout']);
    }

        public function index()
    {
        return view("logistics.auth.login");
    }

    public function login(Request $request)
    {
           $validator = Validator::make($request->all(),[
             'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$validator->fails())
        {

            if (Auth::guard('logistics')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->input('remember'))) {
                return redirect()->intended(route('logistics.dashboard'));
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
        Auth::guard('logistics')->logout();
        return redirect()->route('logistics.login');
    }
}
