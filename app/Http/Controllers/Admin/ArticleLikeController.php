<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ArticleLikeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('article_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ArticleLike::with(['user', 'article'])->select(sprintf('%s.*', (new ArticleLike)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'article_like_show';
                $editGate      = 'article_like_edit';
                $deleteGate    = 'article_like_delete';
                $crudRoutePart = 'article-likes';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('article_title', function ($row) {
                return $row->article ? $row->article->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'article']);

            return $table->make(true);
        }

        $users    = User::get();
        $articles = Article::get();

        return view('admin.articleLikes.index', compact('users', 'articles'));
    }

    public function create()
    {
        abort_if(Gate::denies('article_like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.articleLikes.create', compact('users', 'articles'));
    }

    public function store(StoreArticleLikeRequest $request)
    {
        $articleLike = ArticleLike::create($request->all());

        return redirect()->route('admin.article-likes.index');
    }

    public function edit(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articleLike->load('user', 'article');

        return view('admin.articleLikes.edit', compact('users', 'articles', 'articleLike'));
    }

    public function update(UpdateArticleLikeRequest $request, ArticleLike $articleLike)
    {
        $articleLike->update($request->all());

        return redirect()->route('admin.article-likes.index');
    }

    public function show(ArticleLike $articleLike)
    {
        abort_if(Gate::denies('article_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleLike->load('user', 'article');

        return view('admin.articleLikes.show', compact('articleLike'));
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
