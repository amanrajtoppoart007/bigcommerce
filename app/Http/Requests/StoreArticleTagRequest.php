<?php

namespace App\Http\Requests;

use App\Models\ArticleTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreArticleTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_tag_create');
    }

    public function rules()
    {
        return [
            'title'  => [
                'string',
                'required',
            ],
            'status' => [
                'nullable',
            ],
        ];
    }
}
