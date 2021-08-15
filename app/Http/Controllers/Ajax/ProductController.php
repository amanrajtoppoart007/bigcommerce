<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productSearchSelect2(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->term .'%')->select(['id', 'name'])->get();
        return response([
            'data' => $products,
        ]);
    }

    public function productPriceByProduct(Request $request)
    {
        $productPrices = ProductPrice::whereProductId($request->productId)->get();
        return response([
            'data' => $productPrices,
        ]);
    }
}
