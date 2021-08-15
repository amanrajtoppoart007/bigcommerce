<?php

namespace App\Http\Requests;

use App\Models\Pincode;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePincodeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pincode_edit');
    }

    public function rules()
    {
        return [
            'pincode' => [
                'string',
                'required',
            ],
            'block_id' => [
                'integer',
                'required',
            ],
        ];
    }
}
