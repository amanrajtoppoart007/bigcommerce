<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\HelpCenter;
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
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    use CsvImportTrait, UniqueIdentityGeneratorTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'help_center'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

                return view('partials.datatablesActions', compact(
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
            $table->editColumn('contact', function ($row) {
                return $row->mobile ."/\n". $row->email;
            });
            $table->editColumn('help_center_name', function ($row) {
                return $row->help_center ? $row->help_center->name : "";
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" class="user-approval-status" data-status="' . $row->approved . '" data-id="' . $row->id . '"  ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return '<input  type="checkbox" class="user-verification-status" data-status="' . $row->verified . '" data-id="' . $row->id . '"   ' . ($row->verified ? 'checked' : null) . '>';
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

            $table->rawColumns(['actions', 'placeholder', 'approved', 'verified', 'roles', 'help_center_name']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crops = Crop::all()->pluck('name', 'id');
        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');
        $helpCenters = HelpCenter::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.users.create', compact('crops', 'pincodes', 'states', 'districts', 'blocks', 'areas', 'helpCenters'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try {
            $registrationNo = $this->generateRegistrationNumber();
            $request->request->add(['registration_number' => $registrationNo]);
            $request->request->add(['approved' => 1]);
            $request->request->add(['verified' => 1]);
            $user = User::create($request->all());
            UserProfile::createProfile(array_merge($request->all(), ['user_id' => $user->id]));
            UserAddress::create(array_merge($request->all(), ['user_id' => $user->id, 'address_type' => 'billing']));
//         $user->notify(new RegistrationSuccessSms());
            $kisanCard = new KishanCard();
            $kisanCard->name = $request->name;
            $kisanCard->user_id = $user->id;
            $kisanCard->registration_date = Carbon::now()->format('Y-m-d');
            $kisanCard->expiry_date = Carbon::now()->addYear()->format('Y-m-d');
            $kisanCard->card_number = $this->generateKisanCardNumber();
            $kisanCard->save();

            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['username'] = $user->email;
            $data['password'] = request()->input('password');
            $data['mobile'] = $user->mobile;
            DB::commit();
            event(new FarmerRegistered($data));
            return redirect()->route('admin.users.show', $user->id);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors($exception->getMessage());
        }
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userAddress = UserAddress::where(['user_id' => $user->id])->first();

        $userAddress->load('district', 'block', 'state', 'area');
        $userProfile = UserProfile::where(['user_id' => $user->id])->first();

        $crops = Crop::all()->pluck('name', 'id');

        $helpCenters = HelpCenter::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.edit', compact('crops', 'user', 'userAddress', 'userProfile', 'pincodes', 'districts', 'blocks', 'states', 'areas', 'helpCenters'));
    }

    public function update(UpdateUserRequest $request, User $user, UserProfile $userProfile, UserAddress $userAddress)
    {
        $user->update($request->all());
        $request->request->add(['crops' => json_encode($request->input('crops', []))]);

        $userProfile = $userProfile->where(['user_id' => $user->id])->update($request->only(
            ['name', 'mobile', 'secondary_mobile', 'agricultural_land', 'crops']
        ));

        $userAddress->where(['user_id' => $user->id])->first()->update($request->only(
            ['user_id', 'street', 'address', 'state_id', 'district_id', 'block_id', 'area_id', 'pincode', 'village']
        ));
        return redirect()->route('admin.users.show', $user->id);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'userOrders', 'userArticles', 'userArticleComments', 'userFollowers', 'followFollowers', 'userArticleLikes', 'userTransactions', 'userUserAddresses', 'userUserProfile', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function changeApprovalStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'status' => 'in:0,1'
        ]);

        try {
            $user = User::find($request->input('id'));
            $user->approved = !($request->input('status'));
            $user->save();
            $result = ["status" => 1, "response" => "success", "message" => "User approval status changed successfully"];
        } catch (\Exception $exception) {
            $result = ["status" => 0, "response" => "error", "message" => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function changeVerificationStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'status' => 'in:0,1'
        ]);

        try {
            $user = User::find($request->input('id'));
            $user->verified = !($request->input('status'));
            $user->save();
            $result = ["status" => 1, "response" => "success", "message" => "User verification status changed successfully"];
        } catch (\Exception $exception) {
            $result = ["status" => 0, "response" => "error", "message" => $exception->getMessage()];
        }
        return response()->json($result, 200);
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
        return view('admin.users.kisanCard', compact('user', 'address', 'kisanCard', 'addressString'));
    }
}
