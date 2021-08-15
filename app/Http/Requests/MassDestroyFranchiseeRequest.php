<?php

namespace App\Http\Requests;

use App\Models\Franchisee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFranchiseeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('franchisee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:franchisees,id',
        ];
    }
}
