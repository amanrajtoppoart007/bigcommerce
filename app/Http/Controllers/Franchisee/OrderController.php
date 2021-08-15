<?php

namespace App\Http\Controllers\Franchisee;

use App\Http\Controllers\Controller;
use App\Models\FranchiseeOrder;
use App\Models\FranchiseeOrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = FranchiseeOrder::whereFranchiseeId(auth()->user()->id);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $showURL = route('franchisee.orders.show', $row->order_number);
                $viewText = trans('global.view');
                return "<a class='btn btn-xs btn-primary' href='{$showURL}'>$viewText</a>";
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?? "";
            });
            $table->editColumn('order_number', function ($row) {
                return $row->order_number ? $row->order_number : "";
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

        return view('franchisee.orders.index');
    }

    public function create()
    {
        $products = Product::get();
        return view('franchisee.orders.create', compact('products'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id.*' => 'exists:products,id',
            'product_price_id.*' => 'exists:product_prices,id',
            'price.*' => 'required|numeric',
            'quantity.*' => 'required|numeric',
            'discount.*' => 'required|numeric',
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'msg' => $validator->errors()->all()
            );
            return response($result);
        }

        DB::beginTransaction();
        try {
            $order = new FranchiseeOrder();
            $order->order_number = rand(000001, 999999);
            $order->franchisee_id = auth()->user()->id;
            $order->status = 'PENDING';
            $order->payment_type = $request->payment_method;
            $order->payment_status = 'PENDING';

            $totalAmount = 0;
            $totalDiscount = 0;
            $grandTotal = 0;


            $productPricesRequest = $request->only('product_id', 'product_price_id', 'quantity');

            $newArr = [];
            foreach ($productPricesRequest as $key => $value) {
                for ($i = 0; $i < sizeof($productPricesRequest['product_id']); $i++) {
                    $newArr[$i][$key] = $value[$i];
                }
            }

            $orderItems = [];

            foreach ($newArr as $item) {
                $productPrice = ProductPrice::find($item['product_price_id']);
                $total = $productPrice->bulk_price * $item['quantity'];
                $discountAmount = $total * $productPrice->bulk_discount / 100;
                $totalAmount += $total;
                $totalDiscount += $discountAmount;
                $grandTotal += $total - $discountAmount;


                $itemDiscountAmount = ($productPrice->bulk_price * $item['quantity']) * $productPrice->bulk_discount / 100;
                $itemTotalAmount = ($productPrice->bulk_price * $item['quantity']) - $itemDiscountAmount;

                $orderItems[] = [
                    'product_id' => $productPrice->product_id,
                    'product_price_id' => $productPrice->id,
                    'price' => $productPrice->bulk_price,
                    'quantity' => $item['quantity'],
                    'discount' => $productPrice->bulk_discount,
                    'discount_amount' => $itemDiscountAmount,
                    'gst' => 0,
                    'total_amount' => $itemTotalAmount,
                    'unit' => $productPrice->unit,
                    'unit_quantity' => $productPrice->quantity,
                ];
            }
            $order->amount = $totalAmount;
            $order->gst = 0;
            $order->discount = $totalDiscount;
            $order->total_amount = $grandTotal;
            $order->save();

            foreach ($orderItems as $item) {
                $item['franchisee_order_id'] = $order->id;
                FranchiseeOrderItem::create($item);
            }
            DB::commit();
            $data = array(
                "status" => true,
                "msg" => 'Order added successfully',
                "order_id" => Crypt::encryptString($order->id),
                'amount' => $grandTotal,
                'user' => auth()->user()
            );
            return json_encode($data);

        } catch (Exception $e) {
            DB::rollBack();
            $data = array(
                "status" => false,
                "msg" => 'Something went wrong!!'
            );
            return json_encode($data);
        }
    }


    public function show($orderNumber)
    {
        $franchiseeOrder = FranchiseeOrder::whereOrderNumber($orderNumber)->first();
        if (!$franchiseeOrder) abort(404);
        return view('franchisee.orders.show', compact('franchiseeOrder'));
    }

    public function makePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_payment_id' => 'required'
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'msg' => $validator->errors()->all()
            );
            return response($result);
        }
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $payment->capture(array('amount' => $payment['amount']));
            } catch (\Exception $e) {
                $result = ["status" => 0, "response" => "error", "message" => $e->getMessage()];
                return response()->json($result, 200);
            }
            DB::beginTransaction();
            try {
                $order = FranchiseeOrder::find(Crypt::decryptString($input['orderId']));
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $input['razorpay_payment_id'];
                $transaction->transaction_type = "App\Models\FranchiseeOrder";
                $transaction->user_id = auth()->user()->id;
                $transaction->order_id = $order->id;
                $transaction->save();

                $order->transaction_id = $transaction->id;
                $order->payment_status = 'SUCCESS';
                $order->save();
                DB::commit();
                $result = ["status" => 1, "response" => "success", "message" => "Payment successful."];
            } catch (Exception $e) {
                DB::rollBack();
                $result = ["status" => 0, "response" => "error", "message" => $e->getMessage()];
            }
            return response()->json($result, 200);
        }
    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderId' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'msg' => $validator->errors()->all()
            );
            return response($result);
        }

        try {
            $order = FranchiseeOrder::find($request->orderId);
            $order->status = 'CANCELLED';
            $order->save();
            $result = ["status" => 1, "response" => "success", "message" => "Order cancelled successful."];
        } catch (Exception $e) {
            $result = ["status" => 0, "response" => "error", "message" => $e->getMessage()];
        }
        return response()->json($result, 200);
    }
}
