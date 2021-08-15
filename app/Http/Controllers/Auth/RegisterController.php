<?php

namespace App\Http\Controllers\Auth;

use App\Events\FarmerRegistered;
use App\Events\FranchiseeRegistered;
use App\Events\HelpCenterRegistered;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\FranchiseeRegistrationRequest;
use App\Http\Requests\HelpCenterRegistrationRequest;
use App\Library\TextLocal\TextLocal;
use App\Mail\FranchiseeWelcomeMessage;
use App\Mail\HelpCenterWelcomeMessage;
use App\Mail\UserWelcomeMessage;
use App\Models\City;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeProfile;
use App\Models\HelpCenter;
use App\Models\HelpCenterProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\FarmerRegistrationRequest;
use App\Models\Crop;
use App\Models\Membership;
use App\Models\Pincode;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use App\Traits\SmsSenderTrait;
use App\Traits\UniqueIdentityGeneratorTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RegisterController extends Controller
{

    use MediaUploadingTrait, SmsSenderTrait, UniqueIdentityGeneratorTrait;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view("guest.auth.register");
    }

    public function farmer()
    {
        $crops = Crop::with(['media'])->get();
        $states = State::get();
        return view("guest.auth.register.farmer", compact("crops", "states"));
    }

    public function storeFarmer(FarmerRegistrationRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $request->request->add(['registration_number' => $this->generateRegistrationNumber()]);
            $user = User::create($request->all());
            $profile = UserProfile::createProfile(array_merge($request->all(), ['user_id' => $user->id]));
            $address = UserAddress::create(array_merge($request->all(), ['user_id' => $user->id,'address_type' => 'billing']));

//            Mail::to($user)->send(new UserWelcomeMessage());

            $data['username'] = $user->email;
            $data['email'] = $user->email;
            $data['name'] = $user->name;
            $data['password'] = request()->input('password');
            $data['mobile'] = $user->mobile;

//            $this->sendRegisteredUserSms($data);

            event(new FarmerRegistered($data));

            $url = route("registration.message",
                [
                    'user' => 'user',
                    'entity_id' => Crypt::encryptString($user->id),
                    'token' => Crypt::encryptString(request()->input('password')),
                ]);
            DB::commit();
            $result = ["status" => 1, "response" => "success", "url" => $url, "message" => "Farmer registration successful"];
        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ["status" => 0, "response" => "error", "message" => $exception->getMessage()];
        }

        return response()->json($result);
    }

    public function helpCenter()
    {


        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representativePincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('guest.auth.register.helpCenter', compact('organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'representativePincodes'));

    }

    public function storeHelpCenter(HelpCenterRegistrationRequest $request, HelpCenter $model)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $request->request->add(['verified' => 1]);
            $request->request->add(['approved' => 1]);
            $request->request->add(['primary_contact' => $request->input('mobile')]);
            $request->request->add(['password' => Hash::make($request->input('password'))]);
            $helpCenter = $model->create($request->all());

            $request->request->add(['help_center_id' => $helpCenter->id]);
            $helpCenterProfile = HelpCenterProfile::create($request->all());

            if ($request->input('image', false)) {
                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }

            if ($request->input('aadhaar_card', false)) {
                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }

            if ($request->input('pan_card', false)) {
                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }

            if ($request->input('address_proof', false)) {
                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }

            if ($request->input('signature', false)) {
                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }


//            if ($helpCenter->id && $helpCenter->email) {
//                Mail::to($helpCenter)->send(new HelpCenterWelcomeMessage());
//            }
//
//            if ($helpCenter->id && $helpCenter->mobile) {
//                $data['username'] = $helpCenter->email;
//                $data['password'] = request()->input('password');
//                $data['mobile'] = $helpCenter->mobile;
//                $this->sendRegisteredHelpCenterSms($data);
//            }

            $data['name'] = $helpCenter->name;
            $data['username'] = $helpCenter->email;
            $data['email'] = $helpCenter->email;
            $data['password'] = request()->input('password');
            $data['mobile'] = $helpCenter->mobile;
            event(new HelpCenterRegistered($data));
//            $this->sendRegisteredHelpCenterSms($data);


            $url = route("registration.message",
                [
                    'user' => 'help-center',
                    'entity_id' => Crypt::encryptString($helpCenter->id),
                    'token' => Crypt::encryptString(request()->input('password')),
                ]);

            $result = ["status" => 1, "response" => "success", "url" => $url, "message" => "Registration Successfully"];
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ["status" => 0, "response" => "error", "message" => $exception->getMessage()];
        }

        return response()->json($result, 200);

    }

    public function franchisee()
    {
        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $representativePincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('guest.auth.register.franchisee', compact('organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'representativePincodes'));

    }

    public function storeFranchisee(FranchiseeRegistrationRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $request->request->add(['verified' => 1]);
            $request->request->add(['approved' => 1]);
            $request->request->add(['password' => Hash::make($request->input('password'))]);
            $franchisee = Franchisee::create($request->all());
            $request->request->add(['franchisee_id' => $franchisee->id, 'primary_contact' => $request->input('mobile')]);
            $franchiseeProfile = FranchiseeProfile::create($request->all());

            if ($request->input('image', false)) {
                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }

            if ($request->input('aadhaar_card', false)) {
                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }

            if ($request->input('pan_card', false)) {
                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }

            if ($request->input('address_proof', false)) {
                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }

            if ($request->input('signature', false)) {
                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $franchiseeProfile->id]);
            }

//            if ($franchisee->id && $franchisee->email) {
//                Mail::to($franchisee)->send(new FranchiseeWelcomeMessage());
//            }
//
//            if ($franchisee->id && $franchisee->mobile) {
//                $data['username'] = $franchisee->email;
//                $data['password'] = request()->input('password');
//                $data['mobile'] = $franchisee->mobile;
//                $this->sendRegisteredFranchiseeSms($data);
//            }

            $data['name'] = $franchisee->name;
            $data['email'] = $franchisee->email;
            $data['username'] = $franchisee->email;
            $data['password'] = request()->input('password');
            $data['mobile'] = $franchisee->mobile;
            event(new FranchiseeRegistered($data));

            $url = route("registration.message",
                [
                    'user' => 'franchisee',
                    'entity_id' => Crypt::encryptString($franchisee->id),
                    'token' => Crypt::encryptString(request()->input('password')),
                ]);
            DB::commit();
            $result = ["status" => 1, "response" => "success", "url" => $url, "message" => "Registration Successfully",];
        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ["status" => 0, "response" => "error", "message" => $exception->getMessage()];
        }


        return response()->json($result, 200);

    }

    public function message($user, $entity_id, $token)
    {
        $id = Crypt::decryptString($entity_id);
        switch ($user) {
            case "franchisee":
                $user = Franchisee::find($id);
                break;
            case "help-center":
                $user = HelpCenter::find($id);
                break;
            default:
                $user = User::find($id);
        }
        $token = Crypt::decryptString($token);

        return view("guest.auth.register.message", compact('user', 'token'));

    }

}
