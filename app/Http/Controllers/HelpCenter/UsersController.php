<?php

namespace App\Http\Controllers\HelpCenter;

use App\Events\FarmerRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Area;
use App\Models\Block;
use App\Models\Crop;
use App\Models\District;
use App\Models\KishanCard;
use App\Models\Pincode;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use App\Notifications\RegistrationSuccessSms;
use App\Traits\UniqueIdentityGeneratorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class UsersController extends Controller
{
    use CsvImportTrait, UniqueIdentityGeneratorTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $pincode = auth()->user()->profile->representative_pincode_id ?? null;
            $query = User::where(['help_center_id' => auth('help_center')->user()->id]);
            $query->orWhereHas('userUserAddresses', function ($q) use($pincode){
                $q->where('pincode_id', $pincode);
            });
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

                return view('helpCenter.include.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->verified ? 'checked' : null) . '>';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];

                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('referral_code', function ($row) {
                return $row->referral_code ? $row->referral_code : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'approved', 'verified', 'roles']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('helpCenter.users.index', compact('roles'));
    }

    public function create()
    {
        $crops = Crop::all()->pluck('name', 'id');
        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('helpCenter.users.create', compact('crops', 'pincodes', 'states', 'districts', 'blocks', 'areas'));
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $registrationNo = $this->generateRegistrationNumber();
            $user = User::create(array_merge($request->all(), [
                'help_center_id' => auth('help_center')->user()->id,
                'registration_number' => $registrationNo,
            ]));
            UserProfile::createProfile(array_merge($request->all(), ['user_id' => $user->id, 'address_type' => 'billing']));
            UserAddress::create(array_merge($request->all(), ['user_id' => $user->id]));
            $kisanCard = new KishanCard();
            $kisanCard->name = $request->name;
            $kisanCard->user_id = $user->id;
            $kisanCard->registration_date = Carbon::now()->format('Y-m-d');
            $kisanCard->expiry_date = Carbon::now()->addYear()->format('Y-m-d');
            $kisanCard->card_number = $this->generateKisanCardNumber();
            $kisanCard->save();
//            $user->notify(new RegistrationSuccessSms());
            DB::commit();

            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['username'] = $user->email;
            $data['password'] = request()->input('password');
            $data['mobile'] = $user->mobile;
            event(new FarmerRegistered($data));
            return redirect()->route('helpCenter.users.show', $user->id);
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(User $user)
    {
        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userAddress = UserAddress::where(['user_id' => $user->id])->first();

        $userAddress->load('district', 'block', 'state', 'area', 'addressPincode');
        $userProfile = UserProfile::where(['user_id' => $user->id])->first();

        $crops = Crop::all()->pluck('name', 'id');
        return view('helpCenter.users.edit', compact('crops', 'user', 'userAddress', 'userProfile', 'pincodes', 'districts', 'blocks', 'states', 'areas'));
    }

    public function update(UpdateUserRequest $request, User $user, UserProfile $userProfile, UserAddress $userAddress)
    {
        $user->update($request->all());
        $request->request->add(['crops' => json_encode($request->input('crops', []))]);

        $userProfile = $userProfile->where(['user_id' => $user->id])->update($request->only(
            ['name', 'mobile', 'secondary_mobile', 'agricultural_land', 'crops']
        ));

        $userAddress->where(['user_id' => $user->id])->update($request->only(
            ['name', 'user_id', 'street', 'address', 'state_id', 'district_id', 'block_id', 'area_id', 'pincode_id', 'village']
        ));
        return redirect()->route('helpCenter.users.show', $user->id);
    }

    public function show(User $user)
    {
        $user->load('roles', 'userOrders', 'userArticles', 'userArticleComments', 'userFollowers', 'followFollowers', 'userArticleLikes', 'userTransactions', 'userUserAddresses', 'userUserProfile', 'userUserAlerts');

        return view('helpCenter.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addUserAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
            'district_id' => 'required',
            'block_id' => 'required',
            'pincode_id' => 'required',
            'area_id' => 'required',
            'street' => 'nullable',
            'address' => 'nullable',
            'address_line_two' => 'nullable',
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $userAddress = new UserAddress();
        $userAddress->state_id = $request->state_id;
        $userAddress->district_id = $request->district_id;
        $userAddress->block_id = $request->block_id;
        $userAddress->pincode_id = $request->pincode_id;
        $userAddress->area_id = $request->area_id;
        $userAddress->street = $request->street;
        $userAddress->address = $request->address;
        $userAddress->address_line_two = $request->address_line_two;
        $userAddress->user_id = $request->user_id;
        if($userAddress->save()){
            return response()->json([
               'status' => true,
               'message' => "Address added successfully."
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Something went wrong please try again."
        ]);
    }

    public function printKisanCard(User $user)
    {
        $address = $user->userUserAddresses->first();
        $addressString = "";
        if($address){
            $addressString = $address->address ? $address->address . ', ' : '';
            $addressString .= $address->street ? $address->street . ', ' : '';
            $addressString .= $address->village ? $address->village . ', ' : '';
            $addressString .= $address->district ? $address->district->name . ', ' : '';
            $addressString .= $address->block ? $address->block->name . ', ' : '';
            $addressString .= $address->state ? $address->state->name . '' : '';
            $addressString .= $address->pincode ? ' - ' . $address->pincode->pincode : '';
        }
        $kisanCard = $user->kisanCards()->latest()->first();
        return view('helpCenter.users.kisanCard', compact('user', 'address', 'kisanCard', 'addressString'));
    }
}
