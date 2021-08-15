<?php

namespace App\Http\Controllers\Admin;

use App\Events\FranchiseeRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFranchiseeRequest;
use App\Http\Requests\StoreFranchiseeRequest;
use App\Http\Requests\UpdateFranchiseeRequest;
use App\Models\Block;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeArea;
use App\Models\Pincode;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FranchiseeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('franchisee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Franchisee::query()->select(sprintf('%s.*', (new Franchisee)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'franchisee_show';
                $editGate = 'franchisee_edit';
                $deleteGate = 'franchisee_delete';
                $crudRoutePart = 'franchisees';

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
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : "";
            });

            $table->editColumn('role', function ($row) {
                return $row->role ? Franchisee::ROLE_SELECT[$row->role] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.franchisees.index');
    }

    public function create()
    {
        abort_if(Gate::denies('franchisee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $states = State::all();
        return view('admin.franchisees.create', compact('states'));
    }

    public function store(StoreFranchiseeRequest $request)
    {
        DB::beginTransaction();
        try {
            $franchisee = new Franchisee();
            $franchisee->name = $request->name;
            $franchisee->email = $request->email;
            $franchisee->mobile = $request->mobile;
            $franchisee->password = Hash::make($request->password);
            $franchisee->approved = true;
            $franchisee->verified = true;
            $franchisee->verified_at = now();
            $franchisee->save();
            $areas = $request->area;
            if(isset($areas)){
                foreach ($areas as $key => $value) {
                    foreach ($value as $area) {
                        $data = [
                            'franchisee_id' => $franchisee->id,
                            'pincode_id' => $key,
                            'area_id' => $area,
                        ];
                        FranchiseeArea::create($data);
                    }
                }
            }

            DB::commit();
            $data['name'] = $franchisee->name;
            $data['email'] = $franchisee->email;
            $data['username'] = $franchisee->email;
            $data['password'] = request()->input('password');
            $data['mobile'] = $franchisee->mobile;
            event(new FranchiseeRegistered($data));
            return redirect()->route('admin.franchisees.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors()->withInput();
        }
    }

    public function edit(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $franchiseeAreas = [];
        $blockId = null;
        $districtId = null;
        $stateId = null;
        foreach ($franchisee->serviceAreas as $area){
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
        return view('admin.franchisees.edit', compact('franchisee', 'states', 'stateId', 'districtId', 'blockId', 'franchiseeAreas'));
    }

    public function update(UpdateFranchiseeRequest $request, Franchisee $franchisee)
    {
        DB::beginTransaction();
        try {
            $franchisee->name = $request->name;
            $franchisee->email = $request->email;
            $franchisee->mobile = $request->mobile;
            $franchisee->password = $request->password ?  Hash::make($request->password) : $franchisee->password;
            $franchisee->approved = true;
            $franchisee->verified = true;
            $franchisee->verified_at = now();
            $franchisee->save();
            $areas = $request->area;
            FranchiseeArea::where('franchisee_id', $franchisee->id)->delete();
            if(isset($areas)){

                foreach ($areas as $key => $value) {
                    foreach ($value as $area) {
                        $data = [
                            'franchisee_id' => $franchisee->id,
                            'pincode_id' => $key,
                            'area_id' => $area,
                        ];
                        FranchiseeArea::create($data);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.franchisees.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors()->withInput();
        }
    }

    public function show(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.franchisees.show', compact('franchisee'));
    }

    public function destroy(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisee->delete();

        return back();
    }

    public function massDestroy(MassDestroyFranchiseeRequest $request)
    {
        Franchisee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
