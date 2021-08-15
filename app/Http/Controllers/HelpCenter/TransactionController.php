<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use App\Models\HelpCenterProfile;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Session;
use Redirect;
use Validator;

class TransactionController extends Controller
{
    public function store(Request $request)
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
            DB::beginTransaction();
            try {
                $membership = Membership::find(Crypt::decryptString($input['membershipId']));
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $input['razorpay_payment_id'];
                $transaction->transaction_type = "App\Models\HelpCenter";
                $transaction->user_id = $membership->member_id;
                $transaction->save();

                $membership->transaction_id = $transaction->id;
                $membership->save();
                DB::commit();
                $result = ["status" => 1, "response" => "success", "message" => "Payment successful."];
            } catch (Exception $e) {
                DB::rollBack();
                $result = ["status" => 0, "response" => "error", "message" => $e->getMessage()];
            }
            return response()->json($result, 200);
        }
    }


    public function storeMembership(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gst_number' => 'nullable',
            'work_area' => 'nullable',
            'plan_type' => 'required|exists:membership_plans,id',
            'payment_method' => 'required',
            'razorpay_payment_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {
            $planType = MembershipPlan::find($request->plan_type);

            $profile = HelpCenterProfile::whereHelpCenterId(auth()->user()->id)->first();

            $profile->work_area = $request->work_area;
            $profile->gst_number = $request->gst_number;
            $profile->registration_fees = $planType->fees;
            $profile->payment_method = $request->payment_method;
            $profile->save();
            $membership = new Membership();
            $membership->member_type = "App\Models\HelpCenter";
            $membership->member_id = auth()->user()->id;
            $membership->plan_type = $planType->plan_type;
            $membership->membership_fees = $planType->fees;
            $membership->membership_status = "INACTIVE";
            $membership->start_date = Carbon::now()->format('Y-m-d');
            $membership->expiry_date = Carbon::now()->addYear()->format('Y-m-d');
            $membership->payment_method = $request->payment_method;

            if(isset($request->razorpay_payment_id) && !empty($request->razorpay_payment_id)){
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $request->razorpay_payment_id;
                $transaction->transaction_type = "App\Models\HelpCenter";
                $transaction->user_id = auth()->user()->id;
                $transaction->save();
                $membership->transaction_id = $transaction->id;
                $membership->membership_status = 'ACTIVE';

            }
            $membership->save();
            DB::commit();
            return response()->json([
               'status' => true,
               'message' => 'Membership added',
                'data' => [
                    'amount' => $planType->fees,
                    'user' => auth()->user()
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Something went wrong"
            ]);
        }
    }

    public function makeMembershipPayment(Request $request)
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
            DB::beginTransaction();
            try {
                $membership = auth()->user()->memberships()->latest()->first();
                $transaction = new Transaction();
                $transaction->status = "Success";
                $transaction->amount = $request->amount;
                $transaction->transaction_number = $input['razorpay_payment_id'];
                $transaction->transaction_type = "App\Models\HelpCenter";
                $transaction->user_id = $membership->member_id;
                $transaction->save();

                $membership->transaction_id = $transaction->id;
                $membership->membership_status = 'ACTIVE';
                $membership->save();
                DB::commit();
                $result = ["status" => 1, "response" => "success", "message" => "Payment successful."];
            } catch (Exception $e) {
                DB::rollBack();
                $result = ["status" => 0, "response" => "error", "message" => $e->getMessage()];
            }
            return response()->json($result, 200);
        }
    }
}
