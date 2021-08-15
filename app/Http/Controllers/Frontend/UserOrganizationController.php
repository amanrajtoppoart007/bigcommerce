<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserOrganizationRequest;
use App\Http\Requests\StoreUserOrganizationRequest;
use App\Http\Requests\UpdateUserOrganizationRequest;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\User;
use App\Models\UserOrganization;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UserOrganizationController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('user_organization_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganizations = UserOrganization::with(['user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state', 'media'])->get();

        $users = User::get();

        $districts = District::get();

        $cities = City::get();

        $states = State::get();

        return view('frontend.userOrganizations.index', compact('userOrganizations', 'users', 'districts', 'cities', 'states'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_organization_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userOrganizations.create', compact('users', 'organization_districts', 'organization_cities', 'organization_states', 'representative_districts', 'representative_cities', 'representative_states'));
    }

    public function store(StoreUserOrganizationRequest $request)
    {
        $userOrganization = UserOrganization::create($request->all());

        if ($request->input('representative_image', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('representative_image')))->toMediaCollection('representative_image');
        }

        if ($request->input('aadhaar_card', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('organization_address_proof', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('organization_address_proof')))->toMediaCollection('organization_address_proof');
        }

        if ($request->input('signature', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $userOrganization->id]);
        }

        return redirect()->route('frontend.user-organizations.index');
    }

    public function edit(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userOrganization->load('user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state');

        return view('frontend.userOrganizations.edit', compact('users', 'organization_districts', 'organization_cities', 'organization_states', 'representative_districts', 'representative_cities', 'representative_states', 'userOrganization'));
    }

    public function update(UpdateUserOrganizationRequest $request, UserOrganization $userOrganization)
    {
        $userOrganization->update($request->all());

        if ($request->input('representative_image', false)) {
            if (!$userOrganization->representative_image || $request->input('representative_image') !== $userOrganization->representative_image->file_name) {
                if ($userOrganization->representative_image) {
                    $userOrganization->representative_image->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('representative_image')))->toMediaCollection('representative_image');
            }
        } elseif ($userOrganization->representative_image) {
            $userOrganization->representative_image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$userOrganization->aadhaar_card || $request->input('aadhaar_card') !== $userOrganization->aadhaar_card->file_name) {
                if ($userOrganization->aadhaar_card) {
                    $userOrganization->aadhaar_card->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($userOrganization->aadhaar_card) {
            $userOrganization->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$userOrganization->pan_card || $request->input('pan_card') !== $userOrganization->pan_card->file_name) {
                if ($userOrganization->pan_card) {
                    $userOrganization->pan_card->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($userOrganization->pan_card) {
            $userOrganization->pan_card->delete();
        }

        if ($request->input('organization_address_proof', false)) {
            if (!$userOrganization->organization_address_proof || $request->input('organization_address_proof') !== $userOrganization->organization_address_proof->file_name) {
                if ($userOrganization->organization_address_proof) {
                    $userOrganization->organization_address_proof->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('organization_address_proof')))->toMediaCollection('organization_address_proof');
            }
        } elseif ($userOrganization->organization_address_proof) {
            $userOrganization->organization_address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$userOrganization->signature || $request->input('signature') !== $userOrganization->signature->file_name) {
                if ($userOrganization->signature) {
                    $userOrganization->signature->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($userOrganization->signature) {
            $userOrganization->signature->delete();
        }

        return redirect()->route('frontend.user-organizations.index');
    }

    public function show(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganization->load('user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state');

        return view('frontend.userOrganizations.show', compact('userOrganization'));
    }

    public function destroy(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganization->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserOrganizationRequest $request)
    {
        UserOrganization::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_organization_create') && Gate::denies('user_organization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UserOrganization();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
