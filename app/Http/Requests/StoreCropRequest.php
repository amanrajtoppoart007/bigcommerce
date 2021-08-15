<?php

namespace App\Http\Requests;

use App\Models\Crop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCropRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crop_create');
    }

    public function rules()
    {
        return [
            'name'    => [
                'string',
                'required',
            ],
            'session' => [
                'required',
            ],
        ];
    }
}
