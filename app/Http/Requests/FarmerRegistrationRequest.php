<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmerRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required",
            "email"=>"required|unique:users,email",
            "mobile"=>"numeric|required|unique:users,mobile|digits:10",
            "secondary_mobile"=>"numeric|required|digits:10",
            "address"=>"required",
            "state_id"=>"required|numeric",
            "district_id"=>"required|numeric",
            "block_id"=>"required|numeric",
            "pincode_id"=>"required|numeric",
            "village"=>"required|string",
            "crops"=>"required|array",
            "agricultural_land"=>"required|numeric",
        ];
    }
}
