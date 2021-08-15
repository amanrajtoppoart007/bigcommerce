<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFranchiseeProfileRequest;
use App\Http\Requests\StoreFranchiseeProfileRequest;
use App\Http\Requests\UpdateFranchiseeProfileRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeProfile;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FranchiseeProfileController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('franchisee_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfiles = FranchiseeProfile::with(['franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city', 'media'])->get();

        $franchisees = Franchisee::get();

        $states = State::get();

        $districts = District::get();

        $cities = City::get();

        return view('frontend.franchiseeProfiles.index', compact('franchiseeProfiles', 'franchisees', 'states', 'districts', 'cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('franchisee_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.franchiseeProfiles.create', compact('franchisees', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities'));
    }

    public function store(StoreFranchiseeProfileRequest $request)
    {
        $franchiseeProfile = FranchiseeProfile::create($request->all());

        if ($request->input('image', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('aadhaar_card', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('address_proof', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
        }

        if ($request->input('signature', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $franchiseeProfile->id]);
        }

        return redirect()->route('frontend.franchisee-profiles.index');
    }

    public function edit(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $franchiseeProfile->load('franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('frontend.franchiseeProfiles.edit', compact('franchisees', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'franchiseeProfile'));
    }

    public function update(UpdateFranchiseeProfileRequest $request, FranchiseeProfile $franchiseeProfile)
    {
        $franchiseeProfile->update($request->all());

        if ($request->input('image', false)) {
            if (!$franchiseeProfile->image || $request->input('image') !== $franchiseeProfile->image->file_name) {
                if ($franchiseeProfile->image) {
                    $franchiseeProfile->image->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($franchiseeProfile->image) {
            $franchiseeProfile->image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$franchiseeProfile->aadhaar_card || $request->input('aadhaar_card') !== $franchiseeProfile->aadhaar_card->file_name) {
                if ($franchiseeProfile->aadhaar_card) {
                    $franchiseeProfile->aadhaar_card->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($franchiseeProfile->aadhaar_card) {
            $franchiseeProfile->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$franchiseeProfile->pan_card || $request->input('pan_card') !== $franchiseeProfile->pan_card->file_name) {
                if ($franchiseeProfile->pan_card) {
                    $franchiseeProfile->pan_card->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($franchiseeProfile->pan_card) {
            $franchiseeProfile->pan_card->delete();
        }

        if ($request->input('address_proof', false)) {
            if (!$franchiseeProfile->address_proof || $request->input('address_proof') !== $franchiseeProfile->address_proof->file_name) {
                if ($franchiseeProfile->address_proof) {
                    $franchiseeProfile->address_proof->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }
        } elseif ($franchiseeProfile->address_proof) {
            $franchiseeProfile->address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$franchiseeProfile->signature || $request->input('signature') !== $franchiseeProfile->signature->file_name) {
                if ($franchiseeProfile->signature) {
                    $franchiseeProfile->signature->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($franchiseeProfile->signature) {
            $franchiseeProfile->signature->delete();
        }

        return redirect()->route('frontend.franchisee-profiles.index');
    }

    public function show(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfile->load('franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('frontend.franchiseeProfiles.show', compact('franchiseeProfile'));
    }

    public function destroy(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyFranchiseeProfileRequest $request)
    {
        FranchiseeProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('franchisee_profile_create') && Gate::denies('franchisee_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FranchiseeProfile();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
