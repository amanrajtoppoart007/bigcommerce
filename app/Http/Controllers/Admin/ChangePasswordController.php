<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('admin.changePassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->withErrors(['error'=> 'You have entered wrong password'])->withInput();
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('message' ,'Password changed successfully!');
    }
}
