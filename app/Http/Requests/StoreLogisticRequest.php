<?php

namespace App\Http\Requests;

use App\Models\Logistic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLogisticRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('logistic_create');
    }

    public function rules()
    {
        return [
            'name'     => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'unique:logistics'
            ],
            'mobile'    => [
                'required',
                'unique:logistics',
                'numeric',
                'digits:10',
            ],
            'password' => [
                'required',
            ]
        ];
    }
}
