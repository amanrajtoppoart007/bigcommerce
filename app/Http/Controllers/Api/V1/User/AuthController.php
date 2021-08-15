<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Events\FarmerRegistered;
use App\Http\Controllers\Api\BaseController;
use App\Models\UserProfile;
use App\Traits\SmsSenderTrait;
use App\Traits\UniqueIdentityGeneratorTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    use SmsSenderTrait, UniqueIdentityGeneratorTrait;

    public function access_step_one(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'validation_error', 'action' => 'retry', 'message' => $validator->errors()->all()];
        } else {
            try {
                if (User::where('mobile', $request->input('mobile'))->doesntExist()) {
                    Otp::where('mobile', $request->input('mobile'))->update(['is_expired' => '1']);
                    $otp = rand(1000, 9999);
                    $data['otp'] = $otp;
                    $data['service_type'] = "registration";
                    $data['mobile'] = $request->input('mobile');
                    $gatewayResponse = $this->sendOtpSms($data);
                    $otpObj = new Otp();
                    $otpObj->mobile = $request->input('mobile');
                    $otpObj->otp = $otp;
                    $otpObj->sms_status = $gatewayResponse->status;
                    $otpObj->gateway_response = json_encode($gatewayResponse);
                    $otpObj->save();

                    $result = ['response' => 'success', 'action' => 'login', 'otp' => $otp, 'message' => 'Please check your mobile for OTP'];

                } else {
                    Otp::where('mobile', $request->input('mobile'))->update(['is_expired' => '1']);
                    $otp = rand(1000, 9999);
                    $data['otp'] = $otp;
                    $data['service_type'] = "login";
                    $data['mobile'] = $request->input('mobile');
                    $gatewayResponse = $this->sendOtpSms($data);
                    $otpObj = new Otp();
                    $otpObj->mobile = $request->input('mobile');
                    $otpObj->otp = $otp;
                    $otpObj->sms_status = $gatewayResponse->status;
                    $otpObj->gateway_response = json_encode($gatewayResponse);
                    $otpObj->save();

                    $result = ['response' => 'success', 'action' => 'login', 'otp' => $otp, 'message' => 'Please check your mobile for OTP'];

                }
            } catch (\Exception $exception) {
                $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
            }
        }


        return response()->json($result, 200);

    }

    public function access_step_two(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'mobile' => 'required|numeric|digits:10',
            'otp' => 'required|numeric|digits:4',
            'device_token' => 'nullable',
        ]);

        if ($validator->fails()) {

            $result = ['status' => 0, 'response' => 'failed', 'message' => $validator->errors()->all()];
        } else {
            DB::beginTransaction();
            try {
                $otpdata = Otp::where('mobile', $request->input('mobile'))->where('is_expired', '0')->first();

                if (!empty($otpdata)) {
                    if ($otpdata->otp == $request->input('otp')) {
                        $v_token = rand(100000, 999999);
                        $obj = Otp::findOrFail($otpdata->id);
                        $obj->v_token = $v_token;
                        $obj->is_expired = '1';
                        $obj->save();

                        if (User::where('mobile', $request->input('mobile'))->exists()) {
                            $password = Hash::make($request->input('otp'));
                            $userData = [
                                'password' => $password,
                                'device_token' => $request->input('device_token')
                            ];
                            User::where('mobile', $request->input('mobile'))->update($userData);
                            $user = User::where('mobile', $request->input('mobile'))->first();
                            $access_token = $user->createToken('user_token')->plainTextToken;
                            $user['access_token'] = $access_token;
                            $result = ['response' => 'success', 'action' => 'logged_in', 'data' => $user, 'message' => 'User logged in successfully'];
                            DB::commit();
                        } else {
                            DB::commit();
                            $data['verification_token'] = $v_token;
                            $result = ['response' => 'success', 'action' => 'register', 'data' => $data, 'message' => 'Otp verification successful ,please create your account'];
                        }
                    } else {
                        DB::rollBack();
                        $result = ['response' => 'error', 'action' => 'retry', 'message' => 'Otp verification failed'];
                    }
                } else {
                    DB::rollBack();
                    $result = ['response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong ,please try after some time'];
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
            }
        }


        return response()->json($result, 200);
    }

    public function access_step_third(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'verification_token' => 'required',
            'device_token' => 'nullable',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'validation_error', 'message' => $validator->errors()->all()];
        } else {
            DB::beginTransaction();
            try {
                $input = $request->json()->all();
                $otp = Otp::where('mobile', $input['mobile'])->where('v_token', $input['verification_token'])->first();

                if ($input['verification_token'] == $otp->v_token) {

                    $input['password'] = Hash::make($otp->otp);
                    $user = new User();
                    $user->name = $input['name'];
                    $user->email = $input['email'];
                    $user->mobile = $input['mobile'];
                    $user->password = $input['password'];
                    $user->device_token = $input['device_token'];
                    $user->registration_number = $this->generateRegistrationNumber();
                    if ($user->save()) {
                        $userProfile = new UserProfile();
                        $userProfile->name = $input['name'];
                        $userProfile->email = $input['email'];
                        $userProfile->mobile = $input['mobile'];
                        $userProfile->user_id = $user->id;
                        $userProfile->save();
                        $data = User::where('id', $user->id)->select('id', 'name', 'email', 'mobile')->first();
                        $data['access_token'] = $user->createToken('user_token')->plainTextToken;
                        $result = ['status' => 1, 'response' => 'success', 'action' => 'verified', 'data' => $data, 'message' => 'User register successfully'];
                        $userData['name'] = $input['name'];
                        $userData['username'] = $input['email'];
                        $userData['email'] = $input['email'];
                        $userData['mobile'] = $input['mobile'];
                        event(new FarmerRegistered($userData));
                        DB::commit();
                    } else {
                        DB::rollBack();
                        $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'User register failed'];
                    }
                } else {
                    DB::rollBack();
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'OPT verification failed'];
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
            }
        }

        return response()->json($result, 200);
    }
}
