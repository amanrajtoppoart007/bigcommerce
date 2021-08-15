<?php

namespace App\Http\Requests;

use App\Models\Cart;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCartRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cart_edit');
    }

    public function rules()
    {
        return [
            'order_id'    => [
                'required',
                'integer',
            ],
            'unit'        => [
                'string',
                'required',
            ],
            'quantity'    => [
                'numeric',
                'required',
            ],
            'amount'      => [
                'numeric',
            ],
            'cart_number' => [
                'string',
                'required',
            ],
        ];
    }
}
