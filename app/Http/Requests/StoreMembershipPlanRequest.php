<?php


namespace App\Http\Requests;


class StoreMembershipPlanRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules()
    {
        return [
            'plan_type' => [
                'required',
                'string',
            ],
            'fees' => [
                'numeric',
                'required',
            ],
            'member_type' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
                'nullable',
            ]
        ];
    }
}
