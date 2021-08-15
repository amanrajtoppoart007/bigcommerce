<?php

namespace App\Http\Controllers\Franchisee;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssignedOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:franchisee");
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::whereFranchiseeId(auth()->user()->id);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $showURL = route('franchisee.assigned-orders.show', $row->order_number);
                $viewText = trans('global.view');
                return "<a class='btn btn-xs btn-primary' href='{$showURL}'>$viewText</a>";
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?? "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('order_number', function ($row) {
                return $row->order_number ? $row->order_number : "";
            });
            $table->editColumn('payment_type', function ($row) {
                return $row->payment_type ? Order::PAYMENT_TYPE_SELECT[$row->payment_type] : '';
            });
            $table->addColumn('sub_total', function ($row) {
                return $row->sub_total ?? '';
            });
            $table->addColumn('gst', function ($row) {
                return $row->gst ?? '';
            });
            $table->addColumn('discount', function ($row) {
                return $row->discount ?? '';
            });
            $table->addColumn('grand_total', function ($row) {
                return $row->grand_total ?? '';
            });
            $table->addColumn('status', function ($row) {
                return $row->status ?? '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('franchisee.assignedOrders.index');
    }

    public function show($orderNumber)
    {
        $order = Order::whereOrderNumber($orderNumber)->first();
        if(!$order) abort(404);
        return view('franchisee.assignedOrders.show', compact('order'));
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

        $order = Order::find($request->id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        if($order->save()){
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

    public function confirmOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->orderId);
            $order->status = "CONFIRMED";
            $order->save();
            foreach ($order->orderItems as $orderItem){

                $isExists = ProductStock::where('franchisee_id', auth()->user()->id)
                    ->where('product_id', $orderItem->product_id)
                    ->where('product_price_id', $orderItem->product_price_id)
                    ->where('quantity', '>=', $orderItem->quantity)
                    ->exists();
                if($isExists){
                    ProductStock::where('franchisee_id', auth()->user()->id)->where('product_id', $orderItem->product_id)->where('product_price_id', $orderItem->product_price_id)->decrement('quantity', $orderItem->quantity);
                }else{
                    DB::rollBack();
                    return response([
                        'status' => false,
                        'message' => 'Some product not in stock'
                    ]);
                }
            }

            DB::commit();
            $data = array(
                "status" => true,
                "message" => 'Order confirmed successfully'
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
}
