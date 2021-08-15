<?php

namespace App\Http\Controllers\HelpCenter;

use App\Events\OrderAssigned;
use App\Events\OrderCreated;
use App\Events\OrderNotAssigned;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Area;
use App\Models\Block;
use App\Models\Cart;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeArea;
use App\Models\HelpCenter;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAddress;
use App\Traits\MailSenderTrait;
use App\Traits\UniqueIdentityGeneratorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    use CsvImportTrait, MailSenderTrait, UniqueIdentityGeneratorTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::whereHelpCenterId(auth()->user()->id)->with(['user', 'address'])->select(sprintf('%s.*', (new Order)->table))->latest();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $showURL = route('helpCenter.orders.show', $row->order_number);
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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('helpCenter.orders.index');
    }

    public function show($orderNumber)
    {
        $order = Order::whereOrderNumber($orderNumber)->first();
        if (!$order) abort(401);
        $franchisees = Franchisee::whereApproved(true)->whereVerified(true)->get();
        return view('helpCenter.orders.show', compact('order', 'franchisees'));
    }

    public function addToCart(Request $request)
    {
        $productPrice = ProductPrice::find($request->productPriceId);
        if ($productPrice) {
            if (Cart::where('product_price_id', $request->productPriceId)->where('help_center_id', auth()->user()->id)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product product is already in cart.'
                ]);
            }
            $cart = new Cart();
            $cart->unit = $productPrice->unit;
            $cart->unit_quantity = $productPrice->quantity;
            $cart->cart_number = rand(00001, 99999);
            $cart->product_id = $productPrice->product_id;
            $cart->product_price_id = $productPrice->id;
            $cart->quantity = 1;
            $cart->amount = $productPrice->price;
            $cart->gst = 0;
            $cart->discount = ($productPrice->discount) + 2;
            $cart->help_center_id = auth()->user()->id;
            if ($cart->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Product added to cart.'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ]);
        }
    }

    public function showCarts()
    {
        $carts = Cart::whereHelpCenterId(auth()->user()->id)->get();
        return view('helpCenter.products.carts', compact('carts'));
    }

    public function updateCartQuantity(Request $request)
    {
        if (Cart::find($request->cartId)->update(['quantity' => $request->quantity])) {
            return response()->json([
                'status' => true,
                'message' => 'Quantity updated successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function removeFromCart(Request $request)
    {
        if (Cart::destroy($request->id)) {
            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function showCheckout(Request $request)
    {
        if(!auth()->user()->carts->count()) return redirect()->route('helpCenter.products.index');
        $pincode = auth()->user()->profile->representative_pincode_id ?? null;
        if ($request->ajax()) {
            $users = User::where(['help_center_id' => auth('help_center')->user()->id])
            ->orWhereHas('userUserAddresses', function ($q) use($pincode){
                $q->where('pincode_id', $pincode);
            })->select('id', 'name', 'mobile', 'email')->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->term . "%");
                $q->orWhere('mobile', 'LIKE', "%" . $request->term . "%");
                $q->orWhere('email', 'LIKE', "%" . $request->term . "%");
            })->whereApproved(true)->get();
            return response()->json([
                'status' => true,
                'message' => 'User fetched.',
                'data' => $users
            ]);
        }

        $grandTotal = 0;

        foreach (auth()->user()->carts as $cart) {
            $total = $cart->amount * $cart->quantity;
            $discountAmount = $total * $cart->discount / 100;
            $grandTotal += $total - $discountAmount;
        }

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::whereApproved(true)->get();
        return view('helpCenter.products.checkout', compact('users', 'states', 'districts', 'blocks', 'pincodes', 'areas', 'grandTotal'));
    }

    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required',
            'paymentMethod' => 'required',
            'addressId' => 'required',
            'razorpay_payment_id' => 'nullable',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $carts = Cart::where('help_center_id', auth()->user()->id)->get();
        if (!count($carts)) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        if($request->paymentMethod == 'ONLINE' && !isset($request->razorpay_payment_id)){
            return response()->json([
                'status' => false,
                'message' => 'Please pay amount.'
            ]);
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->order_number = $this->generateOrderNumber(Order::class);
            $order->user_id = $request->userId;
            $order->status = 'PENDING';
            $order->payment_type = $request->paymentMethod;
            $order->payment_status = $request->paymentMethod == 'CASH' ? 'SUCCESS' : 'PENDING';
            $order->address_id = $request->addressId;
            $userAddress = UserAddress::find($request->addressId);
            $franchiseeIds = FranchiseeArea::where('area_id', $userAddress->area_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
            if (empty($franchiseeIds)) {
                $franchiseeIds = FranchiseeArea::where('pincode_id',  $userAddress->pincode_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
            }
            $counts = [];
            foreach ($franchiseeIds as $franchiseeId) {
                $counts[$franchiseeId] = Order::whereFranchiseeId($franchiseeId)->count();
            }

            $order->franchisee_id = empty($counts) ? null : array_search(min($counts), $counts);
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
            $order->help_center_id = auth()->user()->id;
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
            Cart::where('help_center_id', auth()->user()->id)->delete();

            if(isset($request->razorpay_payment_id) && !empty($request->razorpay_payment_id)){
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $request->razorpay_payment_id;
                $transaction->transaction_type = "App\Models\Order";
                $transaction->user_id = $order->user_id;
                $transaction->order_id = $order->id;
                $transaction->save();
                $order->transaction_id = $transaction->id;
                $order->payment_status = 'SUCCESS';
                $order->save();
            }
            DB::commit();
            event(new OrderCreated($order));
            if(!isset($order->franchisee_id)){
                event(new OrderNotAssigned($order));
            }else{
                event(new OrderAssigned($order));
            }
            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully.',
                'orderId' => Crypt::encryptString($order->id),
                'user' => auth()->user(),
                'amount' => $grandTotal
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function getUserAddresses(Request $request)
    {
        $addresses = UserAddress::whereUserId($request->userId)->with('state', 'district', 'block', 'pincode', 'area')->get();
        return response()->json([
            'status' => true,
            'message' => 'User addresses fetched.',
            'data' => $addresses
        ]);
    }

    public function makePayment(Request $request)
    {
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

            try {
                DB::beginTransaction();
                $order = Order::find(Crypt::decryptString($input['orderId']));
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $input['razorpay_payment_id'];
                $transaction->transaction_type = "App\Models\Order";
                $transaction->user_id = $order->user_id;
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

    public function assignOrder(Request $request)
    {
        $order = Order::find($request->orderId);
        $franchiseeIds = FranchiseeArea::where('area_id', $order->address->area_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
        if (empty($franchiseeIds)) {
            $franchiseeIds = FranchiseeArea::where('pincode_id',  $order->address->pincode_id)->distinct('franchisee_id')->pluck('franchisee_id')->toArray();
        }
        $counts = [];
        foreach ($franchiseeIds as $franchiseeId) {
            $counts[$franchiseeId] = Order::whereFranchiseeId($franchiseeId)->count();
        }
        $order->franchisee_id = empty($counts) ? null : array_search(min($counts), $counts);

        if(empty($franchiseeIds)){
            return response()->json([
                'status' => false,
                'message' => 'Franchisee not available in this area or pincode.'
            ]);
        }

        if ($order->save()) {
            event(new OrderAssigned($order));
            return response()->json([
                'status' => true,
                'message' => 'Order assigned successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.'
        ]);
    }

    public function assignOrderManually(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->franchisee_id = $request->franchiseeId;

        if ($order->save()) {
            event(new OrderAssigned($order));
            return response()->json([
                'status' => true,
                'message' => 'Order assigned successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.'
        ]);
    }

    public function generateInvoice(Request $request)
    {
        $order = Order::find($request->orderId);

        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $invoice->invoice_number = $this->generateInvoiceNumber();
            $invoice->date_time = Carbon::now()->format('Y-m-d h:i:s');
            $invoice->invoiceable_type = "App\Models\Order";
            $invoice->invoiceable_id = $order->id;
            $invoice->userable_type = "App\Models\User";
            $invoice->userable_id = $order->user_id;
            $invoice->transaction_id = $order->transaction_id;
            $invoice->payment_type = $order->payment_type;
            $invoice->amount = $order->sub_total;
            $invoice->gst = $order->gst;
            $invoice->discount = $order->discount;
            $invoice->total = $order->grand_total;
            $invoice->save();

            $order->is_invoice_generated = true;
            if($order->save()){
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Invoice generated successfully.'
                ]);
            };
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.'
            ]);


        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function verifyPayment(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->paymentable_type = "App\Models\HelpCenter";
        $order->paymentable_id = auth()->user()->id;
        $order->is_payment_verified = true;
        $order->payment_status = "SUCCESS";
        if ($order->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Payment verified successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.'
        ]);
    }
}
