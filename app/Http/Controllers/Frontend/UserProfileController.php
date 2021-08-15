<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserProfileRequest;
use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use App\Models\UserProfile;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userProfiles = UserProfile::with(['user', 'media'])->get();

        $users = User::get();

        return view('frontend.userProfiles.index', compact('userProfiles', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userProfiles.create', compact('users'));
    }

    public function store(StoreUserProfileRequest $request)
    {
        $userProfile = UserProfile::create($request->all());

        if ($request->input('image', false)) {
            $userProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $userProfile->id]);
        }

        return redirect()->route('frontend.user-profiles.index');
    }

    public function edit(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userProfile->load('user');

        return view('frontend.userProfiles.edit', compact('users', 'userProfile'));
    }

    public function update(UpdateUserProfileRequest $request, UserProfile $userProfile)
    {
        $userProfile->update($request->all());

        if ($request->input('image', false)) {
            if (!$userProfile->image || $request->input('image') !== $userProfile->image->file_name) {
                if ($userProfile->image) {
                    $userProfile->image->delete();
                }

                $userProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($userProfile->image) {
            $userProfile->image->delete();
        }

        return redirect()->route('frontend.user-profiles.index');
    }

    public function show(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userProfile->load('user');

        return view('frontend.userProfiles.show', compact('userProfile'));
    }

    public function destroy(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserProfileRequest $request)
    {
        UserProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_profile_create') && Gate::denies('user_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UserProfile();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
