<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\TextLocal\TextLocal;
class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $sms = new TextLocal();
        $sms->send("this is test",8839421623,"DGNRAY");
    }
}
