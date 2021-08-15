<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyArticleTagRequest;
use App\Http\Requests\StoreArticleTagRequest;
use App\Http\Requests\UpdateArticleTagRequest;
use App\Models\ArticleTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ArticleTagController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('article_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ArticleTag::query()->select(sprintf('%s.*', (new ArticleTag)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'article_tag_show';
                $editGate      = 'article_tag_edit';
                $deleteGate    = 'article_tag_delete';
                $crudRoutePart = 'article-tags';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->status ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'status']);

            return $table->make(true);
        }

        return view('admin.articleTags.index');
    }

    public function create()
    {
        abort_if(Gate::denies('article_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.articleTags.create');
    }

    public function store(StoreArticleTagRequest $request)
    {
        $articleTag = ArticleTag::create($request->all());

        return redirect()->route('admin.article-tags.index');
    }

    public function edit(ArticleTag $articleTag)
    {
        abort_if(Gate::denies('article_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.articleTags.edit', compact('articleTag'));
    }

    public function update(UpdateArticleTagRequest $request, ArticleTag $articleTag)
    {
        $request->request->add(['status' => $request->boolean('status')]);
        $articleTag->update($request->all());

        return redirect()->route('admin.article-tags.index');
    }

    public function show(ArticleTag $articleTag)
    {
        abort_if(Gate::denies('article_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleTag->load('tagsArticles');

        return view('admin.articleTags.show', compact('articleTag'));
    }

    public function destroy(ArticleTag $articleTag)
    {
        abort_if(Gate::denies('article_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyArticleTagRequest $request)
    {
        ArticleTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getTag(Request $request)
    {
        $tag = ArticleTag::find($request->id);
        if ($tag) {
            $result = array('status' => true, 'msg' => 'Article Tag found.', 'data' => $tag);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addTag(StoreArticleTagRequest $request)
    {
        $request->request->add(['status' => true]);
        $tag = ArticleTag::create($request->all());
        if($tag){
            $result = array('status'=> true, 'msg'=>'Article Tag added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updateTag(UpdateContentTagRequest $request)
    {
        $tag = ArticleTag::find($request->id)->update($request->all());
        if($tag){
            $result = array('status'=> true, 'msg'=>'Article Tag updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }
}
