<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class UserProfileController extends Controller
{
    public function __construct()
    {
//        abort(404);
    }

    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserProfile::with(['user'])->select(sprintf('%s.*', (new UserProfile)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_profile_show';
                $editGate      = 'user_profile_edit';
                $deleteGate    = 'user_profile_delete';
                $crudRoutePart = 'user-profiles';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('primary_contact', function ($row) {
                return $row->primary_contact ? $row->primary_contact : "";
            });
            $table->editColumn('secondary_contact', function ($row) {
                return $row->secondary_contact ? $row->secondary_contact : "";
            });
            $table->editColumn('farming_land_area', function ($row) {
                return $row->farming_land_area ? $row->farming_land_area : "";
            });
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'image']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.userProfiles.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userProfiles.create', compact('users'));
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

        return redirect()->route('admin.user-profiles.index');
    }

    public function edit(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userProfile->load('user');

        return view('admin.userProfiles.edit', compact('users', 'userProfile'));
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

        return redirect()->route('admin.user-profiles.index');
    }

    public function show(UserProfile $userProfile)
    {
        abort_if(Gate::denies('user_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userProfile->load('user');

        return view('admin.userProfiles.show', compact('userProfile'));
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
