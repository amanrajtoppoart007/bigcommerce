<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transaction_create');
    }

    public function rules()
    {
        return [
            'order_id'           => [
                'required',
                'integer',
            ],
            'status'             => [
                'required',
            ],
            'transaction_number' => [
                'string',
                'required',
            ],
        ];
    }
}
