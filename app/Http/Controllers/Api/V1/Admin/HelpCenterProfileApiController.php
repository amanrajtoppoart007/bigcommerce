<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreHelpCenterProfileRequest;
use App\Http\Requests\UpdateHelpCenterProfileRequest;
use App\Http\Resources\Admin\HelpCenterProfileResource;
use App\Models\HelpCenterProfile;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HelpCenterProfileApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('help_center_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HelpCenterProfileResource(HelpCenterProfile::with(['help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city'])->get());
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

        return (new HelpCenterProfileResource($helpCenterProfile))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HelpCenterProfileResource($helpCenterProfile->load(['help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city']));
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

        return (new HelpCenterProfileResource($helpCenterProfile))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfile->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
