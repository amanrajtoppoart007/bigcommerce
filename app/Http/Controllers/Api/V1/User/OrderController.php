<?php


namespace App\Http\Controllers\Api\V1\User;

use App\Events\OrderAssigned;
use App\Events\OrderCreated;
use App\Events\OrderNotAssigned;
use App\Models\Cart;
use App\Models\FranchiseeArea;
use App\Models\HelpCenter;
use App\Models\HelpCenterProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Traits\UniqueIdentityGeneratorTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrderController extends \App\Http\Controllers\Api\BaseController
{
    use UniqueIdentityGeneratorTrait;
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id,deleted_at,NULL',
            'payment_method' => 'required',
            'razorpay_payment_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if (!UserAddress::whereId($request->input('address_id'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This address does not belong to you."];
            return response()->json($result, 200);
        }

        $carts = Cart::where('user_id', auth()->user()->id)->get();
        if (!count($carts)) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'add', 'message' => 'Sorry your cart is empty'];
            return response()->json($result, 200);
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->order_number = $this->generateOrderNumber(Order::class);
            $order->user_id = auth()->user()->id;
            $order->status = 'PENDING';
            $order->payment_type = strtoupper($request->input('payment_method'));

            $order->payment_status = $request->input('razorpay_payment_id') ? 'SUCCESS' : 'PENDING';
            $order->address_id = $request->input('address_id');
            $subTotal = 0;
            $totalDiscount = 0;
            $grandTotal = 0;

            foreach ($carts as $cart) {
                $total = $cart->amount * $cart->quantity;
                $discountAmount = $total * $cart->discount / 100;
                $subTotal += $total;
                $totalDiscount += $discountAmount;
                $grandTotal += $total - $discountAmount;
            }
            $order->sub_total = $subTotal;
            $order->gst = 0;
            $order->discount = $totalDiscount;
            $order->grand_total = $grandTotal;

            $userAddress = UserAddress::find($request->input('address_id'));

            $helpCenterIds= HelpCenterProfile::where('representative_pincode_id', $userAddress->pincode_id)->orWhere('organization_pincode_id', $userAddress->pincode_id)->pluck('help_center_id')->toArray();
            if(!empty($helpCenterIds)){
                $order->help_center_id = $helpCenterIds[array_rand($helpCenterIds)];
            }

            $franchiseeIds = FranchiseeArea::where('area_id', $userAddress->area_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
            if (empty($franchiseeIds)) {
                $franchiseeIds = FranchiseeArea::where('pincode_id', $userAddress->pincode_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
            }
            $counts = [];
            foreach ($franchiseeIds as $franchiseeId) {
                $counts[$franchiseeId] = Order::whereFranchiseeId($franchiseeId)->count();
            }
            $order->franchisee_id = empty($counts) ? null : array_search(min($counts), $counts);


            $order->save();
            foreach ($carts as $cart) {
                $itemDiscountAmount = ($cart->amount * $cart->quantity) * $cart->discount / 100;
                $itemTotalAmount = ($cart->amount * $cart->quantity) - $itemDiscountAmount;

                $data = [
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_price_id' => $cart->product_price_id,
                    'amount' => $cart->amount,
                    'unit' => $cart->unit,
                    'unit_quantity' => $cart->unit_quantity,
                    'quantity' => $cart->quantity,
                    'discount' => $cart->discount,
                    'discount_amount' => $itemDiscountAmount,
                    'gst' => 0,
                    'total_amount' => $itemTotalAmount,
                    'user_id' => $cart->user_id,
                    'cart_number' => $cart->cart_number,
                ];
                OrderItem::create($data);
            }

            if ($request->input('razorpay_payment_id')) {
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $itemTotalAmount;
                $transaction->transaction_number = $request->input('razorpay_payment_id');
                $transaction->transaction_type = "App\Models\Order";
                $transaction->user_id = auth()->user()->id;
                $transaction->order_id = $order->id;
                $transaction->save();
                $order->transaction_id = $transaction->id;
                $order->payment_status = 'SUCCESS';
                $order->save();
            }

            Cart::where('user_id', auth()->user()->id)->delete();
            DB::commit();
            $order->refresh();
            $result = ['status' => 1, 'response' => 'success', 'action' => 'placed','data'=>['order_number'=>$order->order_number], 'message' => 'Order placed successfully'];
            event(new OrderCreated($order));
            if(!isset($order->franchisee_id)){
                event(new OrderNotAssigned($order));
            }else{
                event(new OrderAssigned($order));
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getOrders()
    {
        try {
            $orders = Order::whereUserId(auth()->user()->id)->get();
            if (count($orders)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $orders, 'message' => 'Order data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'add', 'message' => 'You have no order at the moment'];
            }

        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getOrderDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|exists:orders',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if (!Order::whereOrderNumber($request->input('order_number'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This order does not belong to you."];
            return response()->json($result, 200);
        }

        try {
            $order = Order::whereOrderNumber($request->input('order_number'))->first();

            $orderItems = OrderItem::where('order_id', $order->id)->with('product')->get();

            $addressObj = $order->address()->withTrashed()->first();

            $address = $addressObj->address;
            $address .= $addressObj->landmark ? ", " . $addressObj->landmark : "";
            $address .= $addressObj->landmark ? ", " . $addressObj->landmark : "";
            $address .= $addressObj->city ? ", " . $addressObj->city->name : "";
            $address .= $addressObj->state ? ", " . $addressObj->state->name : "";
            $address .= $addressObj->pincode ? " - " . $addressObj->pincode->pincode : "";

            $data = [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'payment_type' => $order->payment_type,
                'sub_total' => $order->sub_total,
                'gst' => $order->gst,
                'discount' => $order->discount,
                'grand_total' => $order->grand_total,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'order_date' => Carbon::parse($order->created_at)->format('d-m-Y'),
                'name' => $addressObj->name,
                'address' => $address,
            ];

            foreach ($orderItems as $orderItem) {

                $thumbLink = null;
                foreach ($orderItem->product->images as $key => $media) {
                    if ($key == 0) $thumbLink = $media->getUrl('thumb');
                    break;
                }
                $data['list'][] = [
                    'id' => $orderItem->id,
                    'cart_number' => $orderItem->cart_number,
                    'product_id' => $orderItem->product_id,
                    'product' => $orderItem->product->name,
                    'product_price_id' => $orderItem->product_price_id,
                    'unit' => $orderItem->unit,
                    'unit_quantity' => $orderItem->unit_quantity,
                    'quantity' => $orderItem->quantity,
                    'amount' => $orderItem->amount,
                    'gst' => $orderItem->gst,
                    'discount' => $orderItem->discount,
                    'discount_amount' => $orderItem->discount_amount,
                    'total_amount' => $orderItem->total_amount,
                    'thumb_link' => $thumbLink
                ];
            }
            if (!empty($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Order details fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'add', 'message' => 'Order details not available'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'order_number' => 'required|exists:orders',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if (!Order::whereOrderNumber($request->input('order_number'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This order does not belong to you."];
            return response()->json($result, 200);
        }

        try {
            $order = Order::whereOrderNumber($request->input('order_number'))->first();
            $order->status = "CANCELLED";
            if ($order->save()) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'cancelled', 'message' => 'Order cancelled successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }
}
