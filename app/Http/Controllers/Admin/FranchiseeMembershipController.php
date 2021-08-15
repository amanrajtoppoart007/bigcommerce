<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchisee;
use App\Models\Membership;
use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FranchiseeMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Membership::query();
            $query->whereMemberType(Franchisee::class);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return "<a class='btn btn-xs btn-info' href='". route('admin.franchisee-memberships.edit', $row->id) ."'>". trans('global.edit') ."</a>";
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('member_name', function ($row) {
                return $row->member ? $row->member->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        $franchisees = Franchisee::pluck('name', 'id');
        return view('admin.franchiseeMemberships.index', compact('franchisees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $membershipPlans = MembershipPlan::whereMemberType('FRANCHISEE')->whereStatus('ACTIVE')->get();
        return view('admin.franchiseeMemberships.create', compact('membershipPlans', 'franchisees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required:exists:help_centers,id',
            'plan_type' => 'required|exists:membership_plans,id',
            'membership_status' => 'required',
            'payment_method' => 'required',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
        ]);

        $planType = MembershipPlan::find($request->plan_type);

        $membership = new Membership();
        $membership->member_id = $request->member_id;
        $membership->member_type = "App\Models\Franchisee";
        $membership->plan_type = $planType->plan_type;
        $membership->membership_fees = $planType->fees;
        $membership->membership_status = $request->membership_status;
        $membership->start_date = $request->start_date;
        $membership->expiry_date = $request->expiry_date;
        $membership->payment_method = $request->payment_method;

        if($membership->save()){
            return redirect()->route('admin.franchisee-memberships.index');
        }
        return back()->withErrors()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        if($membership->member_type !== Franchisee::class){
            abort(404);
        }
        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $membershipPlans = MembershipPlan::whereMemberType('FRANCHISEE')->whereStatus('ACTIVE')->get();
        return view('admin.franchiseeMemberships.edit', compact('membership','membershipPlans', 'franchisees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'plan_type' => 'required|exists:membership_plans,id',
            'membership_status' => 'required',
            'payment_method' => 'required',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
        ]);

        $planType = MembershipPlan::find($request->plan_type);

        $membership = Membership::find($id);
        $membership->plan_type = $planType->plan_type;
        $membership->membership_fees = $planType->fees;
        $membership->membership_status = $request->membership_status;
        $membership->start_date = $request->start_date;
        $membership->expiry_date = $request->expiry_date;
        $membership->payment_method = $request->payment_method;

        if($membership->save()){
            return redirect()->route('admin.franchisee-memberships.index');
        }
        return back()->withErrors()->withInput();
    }

}
