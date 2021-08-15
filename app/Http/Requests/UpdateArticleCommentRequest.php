<?php

namespace App\Http\Requests;

use App\Models\ArticleComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateArticleCommentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_comment_edit');
    }

    public function rules()
    {
        return [
            'comment'    => [
                'required',
            ],
            'status'     => [
                'required',
            ],
            'article_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
