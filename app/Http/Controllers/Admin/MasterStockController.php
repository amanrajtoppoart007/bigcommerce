<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterStock;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MasterStockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterStock::with(['product', 'productPrice'])->select(sprintf('%s.*', (new MasterStock())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('unit', function ($row) {
                return $row->productPrice ? $row->productPrice->quantity . ' ' . $row->productPrice->unit : '';
            });
            $table->editColumn('new_stock', function ($row) {
                return "<input type='number' name='new_stock' class='form-control new-stock' placeholder='New stock'>";
            });

            $table->editColumn('actions', function ($row) {
                return "<button data-stock='" . $row->stock . "' data-id='". $row->id ."' class='btn btn-xs btn-danger apply-button'>". trans('global.apply') ."</button>";
            });

            $table->rawColumns(['actions', 'placeholder', 'unit', 'new_stock']);

            return $table->make(true);
        }
        $units = UnitType::pluck('name');
        return view('admin.masterStocks.index', compact('units'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'newStock' => 'required|numeric'
        ]);

        if(MasterStock::find($request->id)->update(['stock' => $request->newStock])){
            return response([
                'status' => true,
                'msg' => 'Stock updated successfully.'
            ]);
        }
        return response([
            'status' => false,
            'msg' => 'Something went wrong.'
        ]);

    }
}
