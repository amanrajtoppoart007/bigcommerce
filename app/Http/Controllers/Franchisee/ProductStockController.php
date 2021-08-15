<?php

namespace App\Http\Controllers\Franchisee;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductStockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductStock::whereFranchiseeId(auth()->user()->id)->with('product');
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : "";
            });
            $table->editColumn('unit', function ($row) {
                return $row->unit ? $row->unit_quantity . ' ' . $row->unit : '';
            });
            $table->rawColumns(['placeholder']);

            return $table->make(true);
        }
        return view('franchisee.productStocks.index');
    }
}
