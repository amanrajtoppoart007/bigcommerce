<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyArticleLikeRequest;
use App\Http\Requests\StoreArticleLikeRequest;
use App\Http\Requests\UpdateArticleLikeRequest;
use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleLikeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('article_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleLikes = ArticleLike::with(['user', 'article'])->get();

        $users = User::get();

        $articles = Article::get();

        return view('frontend.articleLikes.index', compact('articleLikes', 'users', 'articles'));
    }

    public function create()
    {
        abort_if(Gate::denies('article_like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.articleLikes.create', compact('users', 'articles'));
    }

    public function store(StoreArticleLikeRequest $request)
    {
        $articleLike = ArticleLike::create($request->all());

        return redirect()->route('frontend.article-likes.index');
    }

    public function edit(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articleLike->load('user', 'article');

        return view('frontend.articleLikes.edit', compact('users', 'articles', 'articleLike'));
    }

    public function update(UpdateArticleLikeRequest $request, ArticleLike $articleLike)
    {
        $articleLike->update($request->all());

        return redirect()->route('frontend.article-likes.index');
    }

    public function show(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleLike->load('user', 'article');

        return view('frontend.articleLikes.show', compact('articleLike'));
    }

    public function destroy(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleLike->delete();

        return back();
    }

    public function massDestroy(MassDestroyArticleLikeRequest $request)
    {
        ArticleLike::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
