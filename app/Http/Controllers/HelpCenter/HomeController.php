<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\HelpCenterUploadDocumentRequest;
use App\Models\Block;
use App\Models\District;
use App\Models\HelpCenter;
use App\Models\HelpCenterProfile;
use App\Models\MembershipPlan;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    use MediaUploadingTrait;

    public function __construct()
    {
        $this->middleware("auth:help_center");
    }
    public function index()
    {
        $pendingOrdersCount = auth()->user()->orders()->whereStatus('PENDING')->count();
        $totalOrdersCount = auth()->user()->orders()->count();
        $productsCount = Product::count();
        $usersQuery = User::where(['help_center_id' => auth('help_center')->user()->id])
            ->orWhereHas('userUserAddresses', function ($q){
            $q->where('pincode_id', auth()->user()->profile->representative_pincode_id ?? null);
            $q->orWhere('pincode_id', auth()->user()->profile->organization_pincode_id ?? null);
        });
        $cartsCount = auth()->user()->carts()->count();
        $recentOrders = auth()->user()->orders()->latest()->limit(5)->get();
        $usersCount = $usersQuery->count();
        $recentUsers = $usersQuery->latest()->limit(5)->get();
        return view("helpCenter.dashboard", compact('pendingOrdersCount', 'totalOrdersCount', 'productsCount', 'usersCount', 'cartsCount', 'recentOrders', 'recentUsers'));
    }

    public function showDocumentsUploadForm()
    {
        $helpCenterProfile = auth()->user()->profile;
        return view('helpCenter.uploadDocuments', compact('helpCenterProfile'));
    }

    public function uploadDocuments(HelpCenterUploadDocumentRequest $request)
    {
        $helpCenterProfile = HelpCenterProfile::where('help_center_id', auth()->user()->id)->first();
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

        return redirect()->route('helpCenter.dashboard');
    }

    public function showMembershipPaymentForm()
    {
        $profile = HelpCenterProfile::whereHelpCenterId(auth()->user()->id)->first();
        $membership = auth()->user()->memberships()->latest()->first();
        $membershipPlans = MembershipPlan::whereMemberType('HELP_CENTER')->whereStatus('ACTIVE')->get();
        return view('helpCenter.membershipPayment', compact('profile', 'membership',  'membershipPlans'));
    }

    public function showProfileForm()
    {
        $helpCenter = auth()->user();
        $profile = auth()->user()->profile;

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('helpCenter.myProfile', compact('helpCenter', 'profile', 'states', 'districts', 'cities', 'pincodes'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required|regex:/^([6-9]{1}[0-9]{9})$/|unique:help_centers,mobile,' . auth()->user()->id,
            'email' => 'required|unique:help_centers,email,' . auth()->user()->id,
            'secondary_contact' => 'required|regex:/^([6-9]{1}[0-9]{9})$/',
            'gst_number' => 'nullable|string',
            'work_area' => 'nullable|string',
            'organization_name' => 'nullable|string',
            'organization_address' => 'nullable|string',
            'organization_address_line_two' => 'nullable|string',
            'organization_street' => 'nullable|string',
            'organization_state_id' => 'nullable|integer',
            'organization_district_id' => 'nullable|integer',
            'organization_city_id' => 'nullable|integer',
            'organization_pincode_id' => 'nullable|integer',
            'representative_name' => 'required|string',
            'representative_designation' => 'nullable|string',
            'representative_address' => 'required|string',
            'representative_address_line_two' => 'nullable|string',
            'representative_street' => 'required|string',
            'representative_state_id' => 'required|integer',
            'representative_district_id' => 'required|integer',
            'representative_city_id' => 'required|integer',
            'representative_pincode_id' => 'required|integer',
        ]);
        DB::beginTransaction();
        try {
            HelpCenter::find(auth()->user()->id)->update($request->all());
            $request->request->add(['primary_contact' => $request->input('mobile')]);
            $request->request->add(['help_center_id' => auth()->user()->id]);
            HelpCenterProfile::updateOrCreate([
                'id' => auth()->user()->profile->id ?? null
            ], $request->all());
            DB::commit();
            return back()->with('message' ,'Profile updated successfully!');
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function showChangePasswordForm()
    {
        return view('helpCenter.changePassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->withErrors(['error'=> 'You have entered wrong password'])->withInput();
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('message' ,'Password changed successfully!');
    }
}
