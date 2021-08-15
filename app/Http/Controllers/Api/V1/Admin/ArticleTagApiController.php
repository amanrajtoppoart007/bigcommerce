<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleTagRequest;
use App\Http\Requests\UpdateArticleTagRequest;
use App\Http\Resources\Admin\ArticleTagResource;
use App\Models\ArticleTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleTagApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('article_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleTagResource(ArticleTag::all());
    }

    public function store(StoreArticleTagRequest $request)
    {
        $articleTag = ArticleTag::create($request->all());

        return (new ArticleTagResource($articleTag))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ArticleTag $articleTag)
    {
        abort_if(Gate::denies('article_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleTagResource($articleTag);
    }

    public function update(UpdateArticleTagRequest $request, ArticleTag $articleTag)
    {
        $articleTag->update($request->all());

        return (new ArticleTagResource($articleTag))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ArticleTag $articleTag)
    {
        abort_if(Gate::denies('article_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleTag->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
