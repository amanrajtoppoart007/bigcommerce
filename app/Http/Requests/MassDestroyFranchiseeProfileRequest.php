<?php

namespace App\Http\Requests;

use App\Models\FranchiseeProfile;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFranchiseeProfileRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('franchisee_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:franchisee_profiles,id',
        ];
    }
}
