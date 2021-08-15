<?php

namespace App\Http\Requests;

use App\Models\Logistic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLogisticRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('logistic_edit');
    }

    public function rules()
    {
        return [
            'name'   => [
                'string',
                'required',
            ],
            'email'  => [
                'required',
                'unique:logistics,email,' . request()->route('logistic')->id,
            ],
            'mobile'  => [
                'required',
                'numeric',
                'digits:10',
                'unique:logistics,mobile,' . request()->route('logistic')->id,
            ],
            'password' => [
                'nullable',
            ],
        ];
    }
}
