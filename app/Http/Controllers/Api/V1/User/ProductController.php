<?php


namespace App\Http\Controllers\Api\V1\User;


use App\Library\Api\V1\User\ProductList;
use App\Models\Product;
use App\Models\Review;
use App\Models\UserAddress;
use App\Traits\ProductTrait;
use App\Traits\ReviewTrait;
use Illuminate\Http\Request;
use Validator;

class ProductController extends \App\Http\Controllers\Api\BaseController
{
    use ProductTrait, ReviewTrait;
    public function getLatestProducts(Request $request)
    {
        $validatable = [];

        $pincode = null;
        $area = null;

        if(!auth('sanctum')->check()){
            $validatable['pincode_id'] = 'required';
            $validatable['area_id'] = 'required';
            $pincode = $request->input('pincode_id');
            $area = $request->input('area_id');
        }else{
            $address = auth('sanctum')->user()->userUserAddresses->first();
            if(!$address){
                $validatable['pincode_id'] = 'required';
                $validatable['area_id'] = 'required';
                $pincode = $request->input('pincode_id');
                $area = $request->input('area_id');
            }else{
                $pincode = $address->pincode_id;
                $area = $request->area_id;
            }
        }
        $validator = Validator::make($request->all(), $validatable);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {

            $products = Product::latest()
                ->with('productPrices', 'categories', 'reviews')
                ->limit(10)->get()->toArray();
            if (count($products)) {
                $class = new ProductList($products, $pincode, $area);
                $data['list'] = $class->execute();
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Product data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No product found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getTopRatedProducts(Request $request)
    {
        $validatable = [];

        $pincode = null;
        $area = null;

        if(!auth('sanctum')->check()){
            $validatable['pincode_id'] = 'required';
            $validatable['area_id'] = 'required';
            $pincode = $request->input('pincode_id');
            $area = $request->input('area_id');
        }else{
            $address = auth('sanctum')->user()->userUserAddresses->first();
            if(!$address){
                $validatable['pincode_id'] = 'required';
                $validatable['area_id'] = 'required';
                $pincode = $request->input('pincode_id');
                $area = $request->input('area_id');
            }else{
                $pincode = $address->pincode_id;
                $area = $request->area_id;
            }
        }
        $validator = Validator::make($request->all(), $validatable);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        try {

            $products = Product::limit(10)
                ->withCount('reviews')->orderBy('reviews_count', 'desc')
                ->with('productPrices', 'categories', 'reviews')
                ->get()->toArray();
            if (count($products)) {
                $class = new ProductList($products, $pincode, $area);
                $data['list'] = $class->execute();
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Product data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No product found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function writeReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'star' => 'required',
            'review' => 'nullable',
        ]);
        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {
            $review = new Review();
            $review->product_id = $request->input('product_id');
            $review->user_id = auth()->user()->id;
            $review->review = $request->input('review');
            $review->star = $request->input('star');
            if ($review->save()) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'added', 'message' => 'Your review added successfully successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);

    }

    public function getProductDetails(Request $request)
    {
        $validatable = [
            'product_id' => 'required|exists:products,id',
        ];

        $pincode = null;
        $area = null;

        if(!auth('sanctum')->check()){
            $validatable['pincode_id'] = 'required';
            $validatable['area_id'] = 'required';
            $pincode = $request->input('pincode_id');
            $area = $request->input('area_id');
        }else{
            $address = auth('sanctum')->user()->userUserAddresses->first();
            if(!$address){
                $validatable['pincode_id'] = 'required';
                $validatable['area_id'] = 'required';
                $pincode = $request->input('pincode_id');
                $area = $request->input('area_id');
            }else{
                $pincode = $address->pincode_id;
                $area = $request->area_id;
            }
        }
        $validator = Validator::make($request->all(), $validatable);


        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        try {
            $product = Product::find($request->input('product_id'));
            if ($product) {

                $data = [];
                $data['id'] = $product->id;
                $data['name'] = $product->name;
                $data['description'] = $product->description;
                $data['stock'] = $this->checkProductStock($product->id, $pincode, $area);
                $data['stock'] = $this->checkProductStock($product->id, $pincode, $area);
                $data['liked'] = $this->checkIfProductLiked($product->id);
                $data['prices'] = [];
                $data['categories'] = [];
                $data['sub_categories'] = [];
                $data['rating'] = $this->calculateRatingAverage($product->id);
                $data['reviews'] = [];
                $data['tags'] = [];
                $images = [];

                foreach ($product->images as $key => $media){
                        $images[] = [
                            'thumbnail' => $media->getUrl('thumb'),
                            'preview' => $media->getUrl('preview'),
                            'original' => $media->getUrl(),
                        ];

                }
                $data['images'] = $images;

                foreach ($product->productPrices as $productPrice) {
                    $data['prices'][] = [
                        'id' => $productPrice->id,
                        'price' => $productPrice->price,
                        'discount' => $productPrice->discount,
                        'unit' => $productPrice->unit,
                        'quantity' => $productPrice->quantity,
                        'stock' => $this->checkProductPriceStock($productPrice->id, $pincode, false, $area),
                        'liked' => $this->checkIfProductProductLiked($productPrice->id),
                    ];
                }

                foreach ($product->categories as $category) {
                    $data['categories'][] = [
                        'name' => $category->name,
                    ];
                }
                foreach ($product->reviews as $review) {
                    $data['reviews'][] = [
                        'review' => $review->review,
                        'rating' => $review->star,
                    ];
                }
                foreach ($product->tags as $tag) {
                    $data['tags'][] = [
                        'name' => $tag->name,
                    ];
                }
                foreach ($product->subCategories as $subCategory) {
                    $data['sub_categories'][] = [
                        'name' => $subCategory->name,
                    ];
                }
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Product data fetched successfully successfully'];

            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Product not found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);


    }

}
