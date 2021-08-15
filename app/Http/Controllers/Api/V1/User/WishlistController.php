<?php


namespace App\Http\Controllers\Api\V1\User;


use App\Models\Wishlist;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends \App\Http\Controllers\Api\BaseController
{
    use ProductTrait;
    public function addToWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_price_id' => 'required|exists:product_prices,id',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }


        if($request->input('product_price_id')){
            $isExists = auth()->user()->wishlists()
                ->whereProductId($request->input('product_id'))
                ->whereProductPriceId($request->input('product_price_id'))
                ->exists();
            if($isExists){
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Product is already in wishlist.'];
                return response()->json($result, 200);
            }
        }else{
            if(auth()->user()->wishlists()->whereProductId($request->input('product_id'))->exists()){
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Product is already in wishlist.'];
                return response()->json($result, 200);
            }
        }


        try {
            $wishlist = new Wishlist();
            $wishlist->product_id = $request->input('product_id');
            $wishlist->product_price_id = $request->input('product_price_id');
            $wishlist->user_id = auth()->user()->id;

            if ($wishlist->save()) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'added', 'message' => 'Product added to wishlist successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function removeFromWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:wishlists',
            'product_price_id' => 'required|exists:wishlists',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {
            if(Wishlist::whereProductPriceId($request->input('product_price_id'))->whereProductId($request->input('product_id'))->whereUserId(auth()->user()->id)->exists()){
                if (Wishlist::whereProductPriceId($request->input('product_price_id'))->whereProductId($request->input('product_id'))->whereUserId(auth()->user()->id)->delete()) {
                    $result = ['status' => 1, 'response' => 'success', 'action' => 'removed', 'message' => 'Product removed from wishlist successfully'];
                }else{
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                }
            }else{
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'This wishlist does not belong to you.'];
            }

        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getWishlists()
    {
        try {
            $data = [];
            $wishlists = auth()->user()->wishlists;
            foreach ($wishlists as $wishlist) {
                $lowestPrice = $this->getLowestPrice($wishlist->product_id);
                $product = $wishlist->product;
                $productPrice = $wishlist->productPrice;
                $data[] = [
                    'id' => $wishlist->id,
                    'product_id' => $wishlist->product_id,
                    'product' => $product->name,
                    'product_price_id' => $wishlist->product_price_id,
                    'price' => $productPrice->price ?? ($lowestPrice->price ?? 0),
                    'discount' => $productPrice->discount ?? ($lowestPrice->discount ?? 0),
                    'unit' => $productPrice->unit ?? ($lowestPrice->unit ?? 0),
                    'quantity' => $productPrice->quantity ?? ($lowestPrice->quantity ?? 0),
                    'thumb_link' => isset($product->images[0]) ? $product->images[0]->thumbnail : null
                ];
            }

            if (count($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Wishlist data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Your wishlist is empty'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);

    }

}
