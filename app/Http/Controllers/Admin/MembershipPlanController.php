<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipPlanRequest;
use App\Http\Requests\UpdateMembershipPlanRequest;
use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MembershipPlan::query();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return "<a class='btn btn-xs btn-info' href='". route('admin.membership-plans.edit', $row->id) ."'>". trans('global.edit') ."</a>";
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('plan_type', function ($row) {
                return $row->plan_type ? $row->plan_type : "";
            });
            $table->editColumn('member_type', function ($row) {
                return $row->member_type ? MembershipPlan::MEMBER_TYPES_RADIO[$row->member_type] : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        return view('admin.membershipPlans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.membershipPlans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembershipPlanRequest $request)
    {
        MembershipPlan::create($request->all());
        return redirect()->route('admin.membership-plans.index');
    }


    public function edit(MembershipPlan $membershipPlan)
    {
        return view('admin.membershipPlans.edit', compact('membershipPlan'));
    }


    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan)
    {
        $membershipPlan->update($request->all());
        return redirect()->route('admin.membership-plans.index');
    }
}
