<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleCommentRequest;
use App\Http\Requests\UpdateArticleCommentRequest;
use App\Http\Resources\Admin\ArticleCommentResource;
use App\Models\ArticleComment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleCommentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('article_comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleCommentResource(ArticleComment::with(['user', 'article'])->get());
    }

    public function store(StoreArticleCommentRequest $request)
    {
        $articleComment = ArticleComment::create($request->all());

        return (new ArticleCommentResource($articleComment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleCommentResource($articleComment->load(['user', 'article']));
    }

    public function update(UpdateArticleCommentRequest $request, ArticleComment $articleComment)
    {
        $articleComment->update($request->all());

        return (new ArticleCommentResource($articleComment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleComment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
