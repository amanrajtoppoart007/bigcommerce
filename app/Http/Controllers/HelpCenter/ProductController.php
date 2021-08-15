<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use App\Models\FranchiseeArea;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStock;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ProductTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::query();
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->term . "%");
            });
            $products = $query->paginate(6);
            $franchiseeAreas = FranchiseeArea::wherePincodeId(auth()->user()->profile->representative_pincode_id ?? null)->pluck('franchisee_id');
            $productStocks = ProductStock::whereIn('franchisee_id', $franchiseeAreas)->pluck('product_price_id')->toArray();
            return view('helpCenter.products.cards', compact('products', 'productStocks'))->render();
        }
        return view('helpCenter.products.index');
    }

    public function checkStockStatus(Request $request)
    {
        $pincode = auth()->user()->profile->representative_pincode_id ?? null;
        $stock = $this->checkProductPriceStock($request->id, $pincode, true);
        if($stock){
            return response([
                'status' => true,
                'response' => trans('global.add_to_cart')
            ]);
        }
        return response([
            'status' => false,
            'response' => trans('global.out_of_stock')
        ]);
    }
}
