<?php

namespace App\Http\Requests;

use App\Models\Crop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCropRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crop_edit');
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
