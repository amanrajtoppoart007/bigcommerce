<?php


namespace App\Http\Controllers\Api\V1\User;


use App\Library\Api\V1\User\CategoryList;
use App\Library\Api\V1\User\ProductList;
use App\Library\Api\V1\User\SubCategoryList;
use App\Models\Cart;
use App\Models\FranchiseeArea;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\ProductStock;
use App\Models\ProductSubCategory;
use App\Models\Wishlist;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CartController extends \App\Http\Controllers\Api\BaseController
{
    use ProductTrait;

    public function getCategories(Request $request)
    {
        try {
            $query = ProductCategory::query();

            if (!empty($request->input('keyword'))) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            $categories = $query->paginate(10);
            if (count($categories)) {
                $categoryList = $categories->toArray();
                $data['current_page'] = $categoryList['current_page'];
                $data['next_page_url'] = $categoryList['next_page_url'];
                $data['last_page_url'] = $categoryList['last_page_url'];
                $data['per_page'] = $categoryList['per_page'];
                $data['total'] = $categoryList['total'];
                $data['list'] = $categoryList['data'];
                $class = new CategoryList($categoryList['data']);
                $data['list'] = $class->execute();
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Category data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No category found'];
            }

        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getSubCategories(Request $request)
    {
        try {
            $query = ProductSubCategory::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('category_id')) {
                $query->where('product_category_id', $request->input('category_id'));
            }

            $subCategories = $query->with('category')->paginate(10);
            if (count($subCategories)) {
                $subCategoryList = $subCategories->toArray();
                $data['current_page'] = $subCategoryList['current_page'];
                $data['next_page_url'] = $subCategoryList['next_page_url'];
                $data['last_page_url'] = $subCategoryList['last_page_url'];
                $data['per_page'] = $subCategoryList['per_page'];
                $data['total'] = $subCategoryList['total'];
                $data['list'] = $subCategoryList['data'];
                $class = new SubCategoryList($subCategoryList['data']);
                $data['list'] = $class->execute();
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'SubCategory data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No sub category found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'nullable',
            'pincode_id' => 'required',
            'area_id' => 'required',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        try {

            $query = Product::query();

            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('category_id')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('product_category_id', $request->input('category_id'));
                });
            }

            if ($request->input('sub_category_id')) {
                $query->whereHas('subCategories', function ($q) use ($request) {
                    $q->where('product_sub_category_id', $request->input('sub_category_id'));
                });
            }

            $products = $query->with('productPrices', 'categories', 'reviews')->paginate(10);

            if (count($products)) {
                $productList = $products->toArray();
                $data['current_page'] = $productList['current_page'];
                $data['next_page_url'] = $productList['next_page_url'];
                $data['last_page_url'] = $productList['last_page_url'];
                $data['per_page'] = $productList['per_page'];
                $data['total'] = $productList['total'];
                $class = new ProductList($productList['data'], $request->input('pincode_id'), $request->input('area_id'));
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

    public function getProductPrices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        try {
            $product = Product::find($request->input('product_id'));

            $data = [];

            foreach ($product->productPrices as $productPrice) {
                $data[] = [
                    'id' => $productPrice->id,
                    'product_id' => $productPrice->product_id,
                    'unit' => $productPrice->unit,
                    'quantity' => $productPrice->quantity,
                    'price' => $productPrice->price,
                    'discount' => $productPrice->discount,
                    'liked' => $this->checkIfProductProductLiked($productPrice->id),
                ];
            }

            if (count($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Product prices data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No product price found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_price_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if(Cart::whereUserId(auth()->user()->id)->where('product_price_id', $request->input('product_price_id'))->exists()){
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Product is already in cart'];
            return response()->json($result, 200);
        }
        DB::beginTransaction();
        try {
            $productPrice = ProductPrice::find($request->input('product_price_id'));
            if ($productPrice) {
                Wishlist::whereUserId(auth()->user()->id)->where('product_price_id', $request->input('product_price_id'))->delete();
                $cart = new Cart();
                $cart->unit = $productPrice->unit;
                $cart->unit_quantity = $productPrice->quantity;
                $cart->quantity = $request->input('quantity');
                $cart->amount = $productPrice->price;
                $cart->cart_number = rand(000001, 999999);
                $cart->product_id = $productPrice->product_id;
                $cart->product_price_id = $productPrice->id;
                $cart->discount = $productPrice->discount;
                $cart->user_id = auth()->user()->id;
                if ($cart->save()) {
                    DB::commit();
                    $result = ['status' => 1, 'response' => 'success', 'action' => 'added', 'message' => 'Product added to the cart successfully'];
                } else {
                    DB::rollBack();
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                }
            } else {
                DB::rollBack();
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Please select correct product'];
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getCarts()
    {
        try {
            $data = [];
            $carts = Cart::whereUserId(auth()->user()->id)->get();
            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);
                $data[] = [
                    'id' => $cart->id,
                    'cart_number' => $cart->cart_number,
                    'product_id' => $cart->product_id,
                    'product' => $product->name,
                    'product_price_id' => $cart->product_price_id,
                    'unit' => $cart->unit,
                    'unit_quantity' => $cart->unit_quantity,
                    'quantity' => $cart->quantity,
                    'amount' => $cart->amount,
                    'gst' => $cart->gst,
                    'discount' => $cart->discount,
                    'thumb_link' => isset($product->images[0]) ? $product->images[0]->thumbnail : null
                ];
            }

            if (count($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Cart data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Your cart is empty'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);

    }

    public function updateCartQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {
            if(Cart::whereId($request->input('cart_id'))->whereUserId(auth()->user()->id)->exists()){
                if($request->input('quantity') == 0){
                    if(Cart::find($request->input('cart_id'))->delete()){
                        $result = ['status' => 1, 'response' => 'success', 'action' => 'removed', 'message' => 'Product removed from cart successfully'];
                    } else {
                        $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                    }
                }else{
                    if (Cart::find($request->input('cart_id'))->update(['quantity' => $request->input('quantity')])) {
                        $result = ['status' => 1, 'response' => 'success', 'action' => 'updated', 'message' => 'Quantity updated successfully'];
                    } else {
                        $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                    }
                }
            }else{
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Cart does not exists'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function removeFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {
            if (Cart::destroy($request->input('cart_id'))) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'removed', 'message' => 'Product removed from cart successfully'];
            }else{
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }
}
