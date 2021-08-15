<?php

namespace App\Http\Controllers\Franchisee;

use App\Http\Controllers\Controller;
use App\Http\Requests\FranchiseeUploadDocumentRequest;
use App\Models\Block;
use App\Models\City;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeArea;
use App\Models\FranchiseeProfile;
use App\Models\MembershipPlan;
use App\Models\Pincode;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:franchisee");
    }

    public function index()
    {
        return view("franchisee.dashboard");
    }

    public function showDocumentsUploadForm()
    {
        $franchiseeProfile = auth()->user()->profile;
        return view('franchisee.uploadDocuments', compact('franchiseeProfile'));
    }

    public function uploadDocuments(FranchiseeUploadDocumentRequest $request)
    {
        $franchiseeProfile = FranchiseeProfile::where('franchisee_id', auth()->user()->id)->first();

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

        return redirect()->route('franchisee.dashboard');
    }

    public function showMembershipPaymentForm()
    {
        $profile = FranchiseeProfile::whereFranchiseeId(auth()->user()->id)->first();
        $membership = auth()->user()->memberships()->latest()->first();
        $membershipPlans = MembershipPlan::whereMemberType('FRANCHISEE')->whereStatus('ACTIVE')->get();
        return view('franchisee.membershipPayment', compact('profile', 'membership',  'membershipPlans'));
    }

    public function showProfileForm()
    {
        $franchisee = auth()->user();
        $profile = auth()->user()->profile;

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('franchisee.myProfile', compact('franchisee', 'profile', 'states', 'districts', 'cities', 'pincodes'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required|regex:/^([6-9]{1}[0-9]{9})$/|unique:franchisees,mobile,' . auth()->user()->id,
            'email' => 'required|unique:franchisees,email,' . auth()->user()->id,
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
            Franchisee::find(auth()->user()->id)->update($request->all());
            $request->request->add(['primary_contact' => $request->input('mobile')]);
            $request->request->add(['franchisee_id' => auth()->user()->id]);
            FranchiseeProfile::updateOrCreate([
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
        return view('franchisee.changePassword');
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

    public function showServiceAreaForm()
    {

        $franchiseeAreas = [];
        $blockId = null;
        $districtId = null;
        $stateId = null;
        foreach (auth()->user()->serviceAreas as $area){
            $pincode = Pincode::find($area->pincode_id);
            $blockId = $pincode->block_id;
            $franchiseeAreas[] = [
                'id' => $area->id,
                'franchisee_id' => $area->franchisee_id,
                'pincode_id' => $area->pincode_id,
                'area_id' => $area->area_id,
            ];
        }

        if($blockId){
            $block = Block::find($blockId);
            $districtId = $block->district_id;
        }
        if($districtId){
            $district = District::find($districtId);
            $stateId = $district->state_id;
        }
        $states = State::all();
        return view('franchisee.serviceArea', compact('stateId', 'districtId', 'blockId', 'states', 'franchiseeAreas'));
    }

    public function saveServiceArea(Request $request)
    {
        DB::beginTransaction();
        try {

            $areas = $request->area;
            FranchiseeArea::where('franchisee_id', auth()->user()->id)->delete();
            foreach ($areas as $key => $value) {
                foreach ($value as $area) {
                    $data = [
                        'franchisee_id' => auth()->user()->id,
                        'pincode_id' => $key,
                        'area_id' => $area,
                    ];
                    FranchiseeArea::create($data);
                }
            }

            DB::commit();
            return back()->with('message' ,'Service saved successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors()->withInput();
        }
    }
}
