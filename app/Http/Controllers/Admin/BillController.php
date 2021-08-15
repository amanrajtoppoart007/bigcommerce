<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\MasterStock;
use App\Models\ProductPrice;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BillController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Bill::with(['vendor'])->select(sprintf('%s.*', (new Bill())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return "<a href='" . route('admin.bills.show', $row->id)  . "' class='btn btn-xs btn-primary'>". trans('global.view') ."</a>";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        $vendors = Vendor::pluck('name', 'id');
        return view('admin.bills.index', compact('vendors'));
    }


    public function create()
    {
        $vendors = Vendor::pluck('name', 'id');
        return view('admin.bills.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'voucher_date' => 'nullable|date',
            'voucher_number' => 'nullable|string',
            'bill_amount' => 'nullable|string',
            'product_id.*' => 'required|exists:products,id',
            'product_price_id.*' => 'required|exists:product_prices,id',
            'quantity.*' => 'required|numeric',
            'price.*' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response(
                array('status' => false, 'msg' => $validator->errors())
            );
        }

        DB::beginTransaction();

        try {
            $bill = new Bill();
            $bill->vendor_id = $request->vendor_id;
            $bill->voucher_date = $request->voucher_date;
            $bill->voucher_number = $request->voucher_number;
            $bill->bill_amount = $request->bill_amount ?? 0;
            $bill->save();

            $billItemsRequest = $request->only(['product_id', 'product_price_id', 'quantity', 'price']);
            $billItems = [];
            foreach ($billItemsRequest as $key => $value) {
                for ($i = 0; $i < sizeof($billItemsRequest['product_id']); $i++) {
                    $billItems[$i][$key] = $value[$i];
                }
            }

            foreach ($billItems as $billItem) {
                $productPrice = ProductPrice::find($billItem['product_price_id']);
                $billItem['bill_id'] = $bill->id;
                $billItem['unit'] = $productPrice->unit;
                $billItem['unit_quantity'] = $productPrice->quantity;

                BillItem::create($billItem);

                $isExists = MasterStock::where('product_price_id', $billItem['product_price_id'])
                    ->where('product_id', $billItem['product_id'])->exists();
                if ($isExists) {
                    MasterStock::where('product_price_id', $billItem['product_price_id'])
                        ->where('product_id', $billItem['product_id'])->increment('stock', $billItem['quantity']);
                } else {
                    $masterStock = new MasterStock();
                    $masterStock->product_id = $billItem['product_id'];
                    $masterStock->product_price_id = $billItem['product_price_id'];
                    $masterStock->stock = $billItem['quantity'];
                    $masterStock->unit = $productPrice->unit;
                    $masterStock->unit_quantity = $productPrice->quantity;
                    $masterStock->save();
                }

            }
            DB::commit();
            return response(array('status' => true, 'msg' => 'Bill added successfully.'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return response([
                'status' => false, 'msg' => $exception->getMessage()
            ]);
        }
    }

    public function show(Bill $bill)
    {
        return view('admin.bills.show', compact('bill'));
    }
}
