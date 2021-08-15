<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFranchiseeProfileRequest;
use App\Http\Requests\UpdateFranchiseeProfileRequest;
use App\Http\Resources\Admin\FranchiseeProfileResource;
use App\Models\FranchiseeProfile;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FranchiseeProfileApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('franchisee_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FranchiseeProfileResource(FranchiseeProfile::with(['franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city'])->get());
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

        return (new FranchiseeProfileResource($franchiseeProfile))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FranchiseeProfileResource($franchiseeProfile->load(['franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city']));
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

        return (new FranchiseeProfileResource($franchiseeProfile))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfile->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
