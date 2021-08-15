<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ArticleCommentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('article_comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ArticleComment::with(['user', 'article'])->select(sprintf('%s.*', (new ArticleComment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'article_comment_show';
                $editGate      = 'article_comment_edit';
                $deleteGate    = 'article_comment_delete';
                $crudRoutePart = 'article-comments';

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

            $table->editColumn('status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->status ? 'checked' : null) . '>';
            });
            $table->addColumn('article_title', function ($row) {
                return $row->article ? $row->article->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'status', 'article']);

            return $table->make(true);
        }

        $users    = User::get();
        $articles = Article::get();

        return view('admin.articleComments.index', compact('users', 'articles'));
    }

    public function create()
    {
        abort_if(Gate::denies('article_comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.articleComments.create', compact('users', 'articles'));
    }

    public function store(StoreArticleCommentRequest $request)
    {
        $articleComment = ArticleComment::create($request->all());

        return redirect()->route('admin.article-comments.index');
    }

    public function edit(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articles = Article::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articleComment->load('user', 'article');

        return view('admin.articleComments.edit', compact('users', 'articles', 'articleComment'));
    }

    public function update(UpdateArticleCommentRequest $request, ArticleComment $articleComment)
    {
        $articleComment->update($request->all());

        return redirect()->route('admin.article-comments.index');
    }

    public function show(ArticleComment $articleComment)
    {
        abort_if(Gate::denies('article_comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleComment->load('user', 'article');

        return view('admin.articleComments.show', compact('articleComment'));
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
