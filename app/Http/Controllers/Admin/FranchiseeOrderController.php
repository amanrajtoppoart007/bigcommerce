<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestrotyFranchiseeOrderRequest;
use App\Models\Franchisee;
use App\Models\FranchiseeOrder;
use App\Models\FranchiseeOrderItem;
use App\Models\MasterStock;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class FranchiseeOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = FranchiseeOrder::with(['franchisee']);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $showURL = route('admin.franchisee-orders.show', $row->id);
                $viewText = trans('global.view');
                $deleteText = trans('global.delete');
                return "<a class='btn btn-xs btn-primary' href='{$showURL}'>$viewText</a> <button class='btn btn-xs btn-danger'>$deleteText</button>";
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?? "";
            });
            $table->editColumn('order_number', function ($row) {
                return $row->order_number ? $row->order_number : "";
            });
            $table->addColumn('franchisee_name', function ($row) {
                return $row->franchisee ? $row->franchisee->name : '';
            });
            $table->editColumn('payment_type', function ($row) {
                return $row->payment_type ? Order::PAYMENT_TYPE_SELECT[$row->payment_type] : '';
            });
            $table->addColumn('amount', function ($row) {
                return $row->amount ?? '';
            });
            $table->addColumn('gst', function ($row) {
                return $row->gst ?? '';
            });
            $table->addColumn('discount', function ($row) {
                return $row->discount ?? '';
            });
            $table->addColumn('total_amount', function ($row) {
                return $row->total_amount ?? '';
            });
            $table->addColumn('status', function ($row) {
                return $row->status ?? '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $franchisees = Franchisee::get();

        return view('admin.franchiseeOrders.index', compact('franchisees'));
    }

    public function show(FranchiseeOrder $franchiseeOrder)
    {
        return view('admin.franchiseeOrders.show', compact('franchiseeOrder'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(FranchiseeOrder $franchiseeOrder)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $franchiseeOrder->orderItems->delete();
        $franchiseeOrder->delete();
        return back();
    }

    public function massDestroy(MassDestrotyFranchiseeOrderRequest $request)
    {
        FranchiseeOrderItem::where('franchisee_order_id', request('ids'))->delete();
        FranchiseeOrder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateStock(Request $request)
    {
        DB::beginTransaction();
        try {
            $franchiseeOrder = FranchiseeOrder::find($request->orderId);
            $franchiseeOrder->is_stock_updated = true;
            $franchiseeOrder->save();
            foreach ($franchiseeOrder->orderItems as $orderItem) {
                $isExists = MasterStock::where('product_id', $orderItem->product_id)
                    ->where('product_price_id', $orderItem->product_price_id)
                    ->where('stock', '>=', $orderItem->quantity)
                    ->exists();
                if ($isExists) {
                    MasterStock::where('product_id', $orderItem->product_id)
                        ->where('product_price_id', $orderItem->product_price_id)
                        ->decrement('stock', $orderItem->quantity);
                } else {
                    DB::rollBack();
                    return response([
                        'status' => false,
                        'message' => 'Some product not in stock'
                    ]);
                }

                $isFranchiseeStockExists = ProductStock::where('franchisee_id', $franchiseeOrder->franchisee_id)->where('product_id', $orderItem->product_id)->where('product_price_id', $orderItem->product_price_id)->exists();
                if ($isFranchiseeStockExists) {
                    ProductStock::where('franchisee_id', $franchiseeOrder->franchisee_id)->where('product_id', $orderItem->product_id)->where('product_price_id', $orderItem->product_price_id)->increment('quantity', $orderItem->quantity);
                } else {
                    $productStock = new ProductStock();
                    $productStock->franchisee_id = $franchiseeOrder->franchisee_id;
                    $productStock->product_id = $orderItem->product_id;
                    $productStock->product_price_id = $orderItem->product_price_id;
                    $productStock->quantity = $orderItem->quantity;
                    $productStock->unit = $orderItem->productPrice->unit;
                    $productStock->unit_quantity = $orderItem->productPrice->quantity;
                    $productStock->save();
                }
            }

            DB::commit();
            $data = array(
                "status" => true,
                "message" => 'Stock updated successfully'
            );
            return json_encode($data);
        } catch (Exception $e) {
            DB::rollBack();
            $data = array(
                "status" => false,
                "message" => 'Something went wrong!!'
            );
            return json_encode($data);
        }

    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'message' => $validator->errors()->all()
            );
            return response($result);
        }

        $order = FranchiseeOrder::find($request->id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        if ($order->save()) {
            return response([
                'status' => true,
                'message' => 'Status changed from ' . ucfirst(strtolower($oldStatus)) . ' to ' . ucfirst(strtolower($request->status))
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Something went wrong'
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $order = FranchiseeOrder::find($request->orderId);
        $order->payment_verified_by = auth()->user()->id;
        $order->is_payment_verified = true;
        $order->payment_status = "SUCCESS";
        if ($order->save()) {
            return response()->json([
                'status' => true,
                'message' => 'payment verified successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.'
        ]);
    }
}
