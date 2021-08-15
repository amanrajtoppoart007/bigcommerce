<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PushNotificationController extends Controller
{
    public function getPushNotifications()
    {
        $notifications = PushNotification::latest()->whereHas('users', function ($q){
            $q->where('user_id', auth()->user()->id);
        })->get();

        $data = [];

        foreach ($notifications as $notification){
            $imageUrl = $notification->photo ? $notification->photo->getUrl() : asset('assets/assets/images/logo-1.png');
            $data[] = [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'imageUrl' => $imageUrl,
                'created_at' => Carbon::parse($notification->created_at)->format('d M Y h:i A')
            ];
        }

        if ($data) {
            $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Notification fetched successfully'];
        } else {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No notification found'];
        }

        return response()->json($result, 200);
    }

    public function getPushNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:push_notifications'
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        $notification = PushNotification::find($request->input('id'));
        $imageUrl = $notification->photo ? $notification->photo->getUrl() : asset('assets/assets/images/logo-1.png');
        $data= [
            'id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'imageUrl' => $imageUrl,
            'created_at' => Carbon::parse($notification->created_at)->format('d M Y h:i A')
        ];

        if ($data) {
            $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Notification details fetched successfully'];
        } else {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No notification found'];
        }

        return response()->json($result, 200);
    }

    public function deletePushNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:push_notifications'
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }


        $notification = PushNotification::find($request->input('id'));

        if ($notification->users()->detach(auth()->user()->id)) {
            $result = ['status' => 1, 'response' => 'success', 'action' => 'delete', 'message' => 'Notification deleted successfully'];
        } else {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong.'];
        }

        return response()->json($result, 200);
    }
}
