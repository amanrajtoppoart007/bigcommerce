<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Resources\Admin\UserProfileResource;
use App\Models\UserProfile;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProfileApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserProfileResource(UserProfile::with(['user'])->get());
    }

    public function store(StoreUserProfileRequest $request)
    {
        $userProfile = UserProfile::create($request->all());

        if ($request->input('image', false)) {
            $userProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new UserProfileResource($userProfile))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserProfileResource($userProfile->load(['user']));
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

        return (new UserProfileResource($userProfile))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userProfile->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
