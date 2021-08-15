<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProductCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\ProductSubCategory;
use App\Models\ProductTag;
use App\Models\UnitType;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class ProductController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Product::with(['categories', 'tags', 'brand'])->select(sprintf('%s.*', (new Product)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_show';
                $editGate      = 'product_edit';
                $deleteGate    = 'product_delete';
                $crudRoutePart = 'products';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('image', function ($row) {
                if($row->images){
                    $imageUrl = $row->images[0]->getUrl();
                    $imageThumbUrl = $row->images[0]->getUrl('thumb');
                    return '<a href="'. $imageUrl .'" target="_blank" style="display: inline-block"><img src="'.$imageThumbUrl .'"></a>';
                }
                return "";
            });
            $table->editColumn('mrp', function ($row) {
                return $row->mrp ? $row->mrp : "";
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });
            $table->editColumn('category', function ($row) {
                $labels = [];

                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('sub_category', function ($row) {
                $labels = [];

                foreach ($row->subCategories as $subCcategory) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $subCcategory->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];

                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount : "";
            });
            $table->addColumn('brand_title', function ($row) {
                return $row->brand ? $row->brand->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category','sub_category', 'tag', 'brand', 'image']);

            return $table->make(true);
        }

        $product_categories = ProductCategory::get();
        $product_tags       = ProductTag::get();
        $brands             = Brand::get();
        $subCategories      = ProductSubCategory::all();

        return view('admin.products.index', compact('product_categories', 'product_tags', 'brands', 'subCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::all()->pluck('name', 'id');

        $tags = ProductTag::all()->pluck('name', 'id');
        $subCategories = ProductSubCategory::all()->pluck('name', 'id');

        $brands = Brand::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $unitTypes          = UnitType::select('name')->whereStatus(true)->get();
        return view('admin.products.create', compact('categories', 'tags', 'brands', 'unitTypes', 'subCategories'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->categories()->sync($request->input('categories', []));
        $product->tags()->sync($request->input('tags', []));

        foreach ($request->input('images', []) as $file) {
            $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $product->id]);
        }
        event(new ProductCreated($product));
        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::all()->pluck('name', 'id');

        $tags = ProductTag::all()->pluck('name', 'id');

        $subCategories = ProductSubCategory::all()->pluck('name', 'id');

        $brands = Brand::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $product->load('categories', 'tags', 'brand', 'subCategories');

        $unitTypes          = UnitType::select('name')->whereStatus(true)->get();
        $productPrices = ProductPrice::where('product_id', $product->id)->get();

        return view('admin.products.edit', compact('categories', 'tags', 'brands', 'product', 'unitTypes', 'subCategories', 'productPrices'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $product->categories()->sync($request->input('categories', []));
        $product->tags()->sync($request->input('tags', []));

        if (count($product->images) > 0) {
            foreach ($product->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $product->images->pluck('file_name')->toArray();

        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('categories', 'tags', 'brand', 'subCategories');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_create') && Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Product();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'categories.*' => 'integer',
            'categories' => 'array',
            'sub_categories.*' => 'integer',
            'sub_categories' => 'array',
            'tags.*'       => 'integer',
            'tags'         => 'array',
            'unit.*' => 'required',
            'quantity.*' => 'required',
            'purchase_price.*' => 'required',
            'price.*' => 'required',
            'bulk_price.*' => 'required',
            'discount.*' => 'required',
            'bulk_discount.*' => 'required',
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'msg' => $validator->errors()->all()
            );
            return json_encode($result);

        } else {
            DB::beginTransaction();
            try {
                $product = new Product();
                $product->name = $request->name;
                $product->description = $request->description;
                $product->brand_id = $request->brand_id;
                $product->save();

                $product->categories()->sync($request->input('categories', []));
                $product->subCategories()->sync($request->input('sub_categories', []));

                $product->tags()->sync($request->input('tags', []));

                foreach ($request->input('images', []) as $file) {
                    $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
                }
                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $product->id]);
                }
                $productUnits = $request->only('unit', 'quantity', 'purchase_price', 'price', 'bulk_price', 'discount', 'bulk_discount');
                $size = sizeof($productUnits['unit']);
                $productUnitsArr = [];
                foreach ($productUnits as $key => $value) {
                    for ($i = 0; $i < $size; $i++) {
                        $productUnitsArr[$i][$key] = $value[$i];
                    }
                }
                $units = [];
                foreach ($productUnitsArr as $value) {
                    $units[] = [
                        'product_id' => $product->id,
                        'unit' => $value['unit'],
                        'quantity' => $value['quantity'],
                        'purchase_price' => $value['purchase_price'],
                        'price' => $value['price'],
                        'bulk_price' => $value['bulk_price'],
                        'discount' => $value['discount'],
                        'bulk_discount' => $value['bulk_discount']
                    ];
                }

                ProductPrice::insert($units);
                DB::commit();
                $data = array(
                    "status" => true,
                    "msg" => 'Product added successfully'
                );
                event(new ProductCreated($product));
                return json_encode($data);
            }catch (Exception $e){
                DB::rollBack();
                $data = array(
                    "status" => false,
                    "msg" => 'Something went wrong!!'
                );
                return json_encode($data);
            }
        }
    }

    public function updateProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'categories.*' => 'integer',
            'categories' => 'array',
            'sub_categories.*' => 'integer',
            'sub_categories' => 'array',
            'tags.*'       => 'integer',
            'tags'         => 'array',
            'unit.*' => 'required',
            'quantity.*' => 'required',
            'purchase_price.*' => 'required',
            'price.*' => 'required',
            'bulk_price.*' => 'required',
            'discount.*' => 'required',
            'bulk_discount.*' => 'required',
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'msg' => $validator->errors()->all()
            );
            return json_encode($result);

        } else {
            DB::beginTransaction();
            try {
                $product = Product::findOrFail($request->id);
                $product->name = $request->name;
                $product->description = $request->description;
                $product->brand_id = $request->brand_id;
                $product->save();

                $product->categories()->sync($request->input('categories', []));
                $product->subCategories()->sync($request->input('sub_categories', []));

                $product->tags()->sync($request->input('tags', []));

                if (count($product->images) > 0) {
                    foreach ($product->images as $media) {
                        if (!in_array($media->file_name, $request->input('images', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $product->images->pluck('file_name')->toArray();

                foreach ($request->input('images', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
                    }
                }

                if ($media = $request->input('ck-media', false)) {
                    Media::whereIn('id', $media)->update(['model_id' => $product->id]);
                }
                $productUnits = $request->only('pu_id', 'unit', 'quantity', 'purchase_price', 'price', 'bulk_price', 'discount', 'bulk_discount');
                $size = sizeof($productUnits['unit']);
                $productUnitsArr = [];
                foreach ($productUnits as $key => $value) {
                    for ($i = 0; $i < $size; $i++) {
                        $productUnitsArr[$i][$key] = $value[$i];
                    }
                }
                $units = [];
                foreach ($productUnitsArr as $value) {
                    $productUnit = [
                        'product_id' => $product->id,
                        'unit' => $value['unit'],
                        'quantity' => $value['quantity'],
                        'purchase_price' => $value['purchase_price'],
                        'price' => $value['price'],
                        'bulk_price' => $value['bulk_price'],
                        'discount' => $value['discount'],
                        'bulk_discount' => $value['bulk_discount']
                    ];

                    $units[] = $productUnit;
                    ProductPrice::updateOrCreate([
                        'id' => $value['pu_id']
                    ], $productUnit);
                }
                DB::commit();
                $data = array(
                    "status" => true,
                    "msg" => 'Product updated successfully'
                );
                return json_encode($data);
            }catch (Exception $e){
                DB::rollBack();
                $data = array(
                    "status" => false,
                    "msg" => 'Something went wrong!!'
                );
                return json_encode($data);
            }
        }
    }
}
