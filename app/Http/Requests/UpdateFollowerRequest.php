<?php

namespace App\Http\Requests;

use App\Models\Follower;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFollowerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('follower_edit');
    }

    public function rules()
    {
        return [
            'user_id'   => [
                'required',
                'integer',
            ],
            'follow_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
