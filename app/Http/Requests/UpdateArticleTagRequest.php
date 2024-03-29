<?php

namespace App\Http\Requests;

use App\Models\ArticleTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateArticleTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_tag_edit');
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
