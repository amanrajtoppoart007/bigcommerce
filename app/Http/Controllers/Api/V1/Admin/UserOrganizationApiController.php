<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUserOrganizationRequest;
use App\Http\Requests\UpdateUserOrganizationRequest;
use App\Http\Resources\Admin\UserOrganizationResource;
use App\Models\UserOrganization;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserOrganizationApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_organization_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserOrganizationResource(UserOrganization::with(['user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state'])->get());
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

        return (new UserOrganizationResource($userOrganization))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserOrganizationResource($userOrganization->load(['user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state']));
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

        return (new UserOrganizationResource($userOrganization))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganization->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
