<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductCategoryRequest;
use App\Http\Requests\StoreProductSubCategoryRequest;
use App\Http\Requests\UpdateProductSubCategoryRequest;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductSubCategoryController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $productSubCategories = ProductSubCategory::with('media', 'category')->get();

        return view('admin.productSubCategories.index', compact('productSubCategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.productSubCategories.create', compact('categories'));
    }

    public function store(StoreProductSubCategoryRequest $request)
    {
        $productSubCategory = ProductSubCategory::create($request->all());

        if ($request->input('photo', false)) {
            $productSubCategory->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productSubCategory->id]);
        }

        return redirect()->route('admin.product-sub-categories.index');
    }

    public function show(ProductSubCategory $productSubCategory)
    {
        return view('admin.productSubCategories.show', compact('productSubCategory'));
    }

    public function edit(ProductSubCategory $productSubCategory)
    {
        $categories = ProductCategory::all();
        return view('admin.productSubCategories.edit', compact('productSubCategory', 'categories'));
    }

    public function update(UpdateProductSubCategoryRequest $request, ProductSubCategory $productSubCategory)
    {
        $productSubCategory->update($request->all());

        if ($request->input('photo', false)) {
            if (!$productSubCategory->photo || $request->input('photo') !== $productSubCategory->photo->file_name) {
                if ($productSubCategory->photo) {
                    $productSubCategory->photo->delete();
                }

                $productSubCategory->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($productSubCategory->photo) {
            $productSubCategory->photo->delete();
        }

        return redirect()->route('admin.product-sub-categories.index');
    }

    public function destroy(ProductSubCategory $productSubCategory)
    {
        $productSubCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductCategoryRequest $request)
    {
        ProductSubCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        $model         = new ProductSubCategory();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
