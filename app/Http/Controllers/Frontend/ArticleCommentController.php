<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyArticleCommentRequest;
use App\Http\Requests\StoreArticleCommentRequest;
use App\Http\Requests\UpdateArticleCommentRequest;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleCommentController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('article_comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleComments = ArticleComment::with(['user', 'article'])->get();

        $users = User::get();

        $articles = Article::get();

        return view('frontend.articleComments.index', compact('articleComments', 'users', 'articles'));
    }

    public function create()
    {
        abort_if(Gate::denies('article_comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.articleComments.create', compact('users', 'articles'));
    }

    public function store(StoreArticleCommentRequest $request)
    {
        $articleComment = ArticleComment::create($request->all());

        return redirect()->route('frontend.article-comments.index');
    }

    public function edit(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articleComment->load('user', 'article');

        return view('frontend.articleComments.edit', compact('users', 'articles', 'articleComment'));
    }

    public function update(UpdateArticleCommentRequest $request, ArticleComment $articleComment)
    {
        $articleComment->update($request->all());

        return redirect()->route('frontend.article-comments.index');
    }

    public function show(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleComment->load('user', 'article');

        return view('frontend.articleComments.show', compact('articleComment'));
    }

    public function destroy(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleComment->delete();

        return back();
    }

    public function massDestroy(MassDestroyArticleCommentRequest $request)
    {
        ArticleComment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
