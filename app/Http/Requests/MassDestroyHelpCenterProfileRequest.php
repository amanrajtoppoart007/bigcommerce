<?php

namespace App\Http\Requests;

use App\Models\HelpCenterProfile;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHelpCenterProfileRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('help_center_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:help_center_profiles,id',
        ];
    }
}
