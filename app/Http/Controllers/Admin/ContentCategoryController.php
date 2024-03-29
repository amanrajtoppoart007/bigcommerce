<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContentCategoryRequest;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;
use App\Models\ContentCategory;
use App\Traits\SlugGeneratorTrait;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentCategoryController extends Controller
{
    use SlugGeneratorTrait;
    public function index()
    {
        abort_if(Gate::denies('content_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentCategories = ContentCategory::all();

        return view('admin.contentCategories.index', compact('contentCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('content_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentCategories.create');
    }

    public function store(StoreContentCategoryRequest $request)
    {
        $contentCategory = ContentCategory::create($request->all());

        return redirect()->route('admin.content-categories.index');
    }

    public function edit(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentCategories.edit', compact('contentCategory'));
    }

    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory)
    {
        $contentCategory->update($request->all());

        return redirect()->route('admin.content-categories.index');
    }

    public function show(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentCategories.show', compact('contentCategory'));
    }

    public function destroy(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyContentCategoryRequest $request)
    {
        ContentCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getCategory(Request $request)
    {
        $category = ContentCategory::find($request->id);
        if ($category) {
            $result = array('status' => true, 'msg' => 'Content Category found.', 'data' => $category);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addCategory(StoreContentCategoryRequest $request)
    {
        $request->request->set('slug', $this->generateSlug(ContentCategory::class, $request->name));
        $category = ContentCategory::create($request->all());
        if($category){
            $result = array('status'=> true, 'msg'=>'Content Category added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updateCategory(UpdateContentCategoryRequest $request)
    {
        $request->request->set('slug', $this->generateSlug(ContentCategory::class, $request->name, null, $request->id));
        $category = ContentCategory::find($request->id)->update($request->all());
        if($category){
            $result = array('status'=> true, 'msg'=>'Content Category updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }
}
