<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function store(Request $request,Enquiry $enquiry)
    {
        $validator = Validator::make($request->all(),[

            "name"=>"required",
            "mobile"=>"required|unique:enquiries,mobile",
            "email"=>"unique:enquiries,mobile",
            "subject"=>"required",
            "message"=>"required",

        ]);

        if(!$validator->fails())
        {
            $enquiry->create($request->all());
        }
        else
        {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }
    }
}
