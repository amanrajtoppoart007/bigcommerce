<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHelpCenterProfileRequest;
use App\Http\Requests\StoreHelpCenterProfileRequest;
use App\Http\Requests\UpdateHelpCenterProfileRequest;
use App\Models\City;
use App\Models\District;
use App\Models\HelpCenter;
use App\Models\HelpCenterProfile;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HelpCenterProfileController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('help_center_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfiles = HelpCenterProfile::with(['help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city', 'media'])->get();

        $help_centers = HelpCenter::get();

        $states = State::get();

        $districts = District::get();

        $cities = City::get();

        return view('frontend.helpCenterProfiles.index', compact('helpCenterProfiles', 'help_centers', 'states', 'districts', 'cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('help_center_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $help_centers = HelpCenter::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.helpCenterProfiles.create', compact('help_centers', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities'));
    }

    public function store(StoreHelpCenterProfileRequest $request)
    {
        $helpCenterProfile = HelpCenterProfile::create($request->all());

        if ($request->input('image', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('aadhaar_card', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('address_proof', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
        }

        if ($request->input('signature', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $helpCenterProfile->id]);
        }

        return redirect()->route('frontend.help-center-profiles.index');
    }

    public function edit(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $help_centers = HelpCenter::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $helpCenterProfile->load('help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('frontend.helpCenterProfiles.edit', compact('help_centers', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'helpCenterProfile'));
    }

    public function update(UpdateHelpCenterProfileRequest $request, HelpCenterProfile $helpCenterProfile)
    {
        $helpCenterProfile->update($request->all());

        if ($request->input('image', false)) {
            if (!$helpCenterProfile->image || $request->input('image') !== $helpCenterProfile->image->file_name) {
                if ($helpCenterProfile->image) {
                    $helpCenterProfile->image->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($helpCenterProfile->image) {
            $helpCenterProfile->image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$helpCenterProfile->aadhaar_card || $request->input('aadhaar_card') !== $helpCenterProfile->aadhaar_card->file_name) {
                if ($helpCenterProfile->aadhaar_card) {
                    $helpCenterProfile->aadhaar_card->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($helpCenterProfile->aadhaar_card) {
            $helpCenterProfile->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$helpCenterProfile->pan_card || $request->input('pan_card') !== $helpCenterProfile->pan_card->file_name) {
                if ($helpCenterProfile->pan_card) {
                    $helpCenterProfile->pan_card->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($helpCenterProfile->pan_card) {
            $helpCenterProfile->pan_card->delete();
        }

        if ($request->input('address_proof', false)) {
            if (!$helpCenterProfile->address_proof || $request->input('address_proof') !== $helpCenterProfile->address_proof->file_name) {
                if ($helpCenterProfile->address_proof) {
                    $helpCenterProfile->address_proof->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }
        } elseif ($helpCenterProfile->address_proof) {
            $helpCenterProfile->address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$helpCenterProfile->signature || $request->input('signature') !== $helpCenterProfile->signature->file_name) {
                if ($helpCenterProfile->signature) {
                    $helpCenterProfile->signature->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($helpCenterProfile->signature) {
            $helpCenterProfile->signature->delete();
        }

        return redirect()->route('frontend.help-center-profiles.index');
    }

    public function show(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfile->load('help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('frontend.helpCenterProfiles.show', compact('helpCenterProfile'));
    }

    public function destroy(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyHelpCenterProfileRequest $request)
    {
        HelpCenterProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('help_center_profile_create') && Gate::denies('help_center_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HelpCenterProfile();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
