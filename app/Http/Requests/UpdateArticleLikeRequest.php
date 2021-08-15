<?php

namespace App\Http\Requests;

use App\Models\ArticleLike;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateArticleLikeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_like_edit');
    }

    public function rules()
    {
        return [
            'user_id'    => [
                'required',
                'integer',
            ],
            'article_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
