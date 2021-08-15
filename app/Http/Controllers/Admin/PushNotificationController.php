<?php

namespace App\Http\Controllers\Admin;

use App\Events\PushNotificationCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\PushNotification;
use App\Models\User;
use App\Traits\FirebaseNotificationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PushNotificationController extends Controller
{
    use MediaUploadingTrait, FirebaseNotificationTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PushNotification::query();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $sendButton = '<button class="btn btn-xs btn-info send-button" data-id="' . $row->id . '">' . trans('global.send') . '</button>';
                $deleteButton = ' <button data-id="' . $row->id . '" class="btn btn-xs btn-danger delete-button">' . trans('global.delete') . '</button>';
                return $sendButton . $deleteButton;
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });


            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }
        $users = User::pluck('name', 'id');
        return view('admin.pushNotifications.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'message' => 'required|string',
            'users.*' => 'required',
            'photo' => 'nullable',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'errors' => $validator->errors()];
            return response()->json($result, 422);
        }

        $notification = new PushNotification();
        $notification->title = $request->title;
        $notification->message = $request->message;

        if ($request->users) {
            $notification->save();

            if ($request->input('photo', false)) {
                $notification->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
            $imageUrl = null;
            if ($notification->photo) {
                $imageUrl = $notification->photo->getUrl('thumb');
            } else {
                $imageUrl = asset('assets/assets/images/logo-1.png');
            }
            $deviceTokens = User::whereIn('id', $request->users)->whereNotNull('device_token')->pluck('device_token', 'id')->toArray();
            if (!empty($deviceTokens)) {
                $usersIds = [];
                foreach ($deviceTokens as $key => $value) {
                    $usersIds[] = $key;
                }
                $notification->users()->sync($usersIds);

                $message = [
                    'title' => $request->title,
                    'body' => $request->message,
                    'imageUrl' => $imageUrl,
                    'created_at' => Carbon::parse($notification->created_at)->format('d M Y h:i A')
                ];
                $data = [
                    'device_tokens' => $deviceTokens,
                    'message' => $message
                ];

                event(new PushNotificationCreated($data));

                $result = ['status' => 1, 'response' => 'success', 'message' => 'Notification sent successfully.'];
                return response()->json($result, 200);
            }
            $result = ['status' => 1, 'response' => 'success', 'message' => 'Notification saved successfully.'];
            return response()->json($result, 200);
        } else {
            $message['users'] = [
                'Please select user'
            ];
            $result = ['status' => 0, 'response' => 'error', 'errors' => $message];
            return response()->json($result, 422);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $notification = PushNotification::find($request->id);
            $notification->users()->detach();
            if ($notification->delete()) {
                DB::commit();
                $result = ['status' => 1, 'response' => 'success', 'message' => 'Notification delete successfully.'];
                return response()->json($result, 200);
            } else {
                DB::rollBack();
                $result = ['status' => 0, 'response' => 'error', 'message' => 'Something went wrong.'];
                return response()->json($result, 200);
            }
        }catch (\Exception $exception){
            DB::rollBack();
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
            return response()->json($result, 200);
        }

    }

    public function massDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:push_notifications,id',
        ]);

        DB::table('push_notification_user')->whereIn('push_notification_id', request('ids'))->delete();
        PushNotification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function send(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $notification = PushNotification::find($request->id);

        $deviceTokens = User::whereNotNull('device_token')->pluck('device_token', 'id')->toArray();

        if (!empty($deviceTokens)) {

            $usersIds = [];
            foreach ($deviceTokens as $key => $value)
            {
                $usersIds[] = $key;
            }
            $notification->users()->sync($usersIds);

            if ($notification->photo) {
                $imageUrl = $notification->photo->getUrl('thumb');
            } else {
                $imageUrl = asset('assets/assets/images/logo-1.png');
            }
            $message = [
                'title' => $request->title,
                'body' => $request->message,
                'imageUrl' => $imageUrl,
                'created_at' => Carbon::parse($notification->created_at)->format('d M Y h:i A')
            ];
            $data = [
                'device_tokens' => $deviceTokens,
                'message' => $message
            ];
            event(new PushNotificationCreated($data));

            $result = ['status' => 1, 'response' => 'success', 'message' => 'Notification sent successfully.'];
            return response()->json($result, 200);
        } else {
            $result = ['status' => 0, 'response' => 'failed', 'message' => 'Device token empty failed to send.'];
            return response()->json($result, 200);
        }
    }
}
