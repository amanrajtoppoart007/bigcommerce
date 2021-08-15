<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

class BaseController extends \App\Http\Controllers\Controller
{
    public function sendResponse($status = "success", $data = [], $message = "", $action = "", $code = 200)
    {
        $response = [
            'response' => $status,
            'data' => $data,
            'message' => $message,
            'action' => $action,
        ];

        return response()->json($response, $code);
    }
}
