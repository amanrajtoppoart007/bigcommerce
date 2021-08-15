<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleLikeRequest;
use App\Http\Requests\UpdateArticleLikeRequest;
use App\Http\Resources\Admin\ArticleLikeResource;
use App\Models\ArticleLike;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleLikeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('article_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleLikeResource(ArticleLike::with(['user', 'article'])->get());
    }

    public function store(StoreArticleLikeRequest $request)
    {
        $articleLike = ArticleLike::create($request->all());

        return (new ArticleLikeResource($articleLike))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleLikeResource($articleLike->load(['user', 'article']));
    }

    public function update(UpdateArticleLikeRequest $request, ArticleLike $articleLike)
    {
        $articleLike->update($request->all());

        return (new ArticleLikeResource($articleLike))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleLike->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
