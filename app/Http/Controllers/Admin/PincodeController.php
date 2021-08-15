<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPincodeRequest;
use App\Http\Requests\StorePincodeRequest;
use App\Http\Requests\UpdatePincodeRequest;
use App\Models\Area;
use App\Models\Block;
use App\Models\Pincode;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PincodeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('pincode_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Pincode::with(['block'])->select(sprintf('%s.*', (new Pincode)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'pincode_show';
                $editGate      = 'pincode_edit';
                $deleteGate    = 'pincode_delete';
                $crudRoutePart = 'pincodes';

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
            $table->editColumn('pincode', function ($row) {
                return $row->pincode ? $row->pincode : "";
            });
            $table->editColumn('status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->status ? 'checked' : null) . '>';
            });
            $table->addColumn('block_name', function ($row) {
                return $row->block ? $row->block->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'block']);

            return $table->make(true);
        }

        $blocks = Block::get();

        return view('admin.pincodes.index', compact('blocks'));
    }

    public function create()
    {
        abort_if(Gate::denies('pincode_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pincodes.create', compact('blocks'));
    }

    public function store(StorePincodeRequest $request)
    {
        $pincode = Pincode::create($request->all());

        return redirect()->route('admin.pincodes.index');
    }

    public function edit(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincode->load('block');

        return view('admin.pincodes.edit', compact('blocks', 'pincode'));
    }

    public function update(UpdatePincodeRequest $request, Pincode $pincode)
    {
        $request->request->add(['status' => $request->boolean('status')]);
        $pincode->update($request->all());

        return redirect()->route('admin.pincodes.index');
    }

    public function show(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincode->load('block', 'pincodeAreas', 'pincodeUserAddresses');

        return view('admin.pincodes.show', compact('pincode'));
    }

    public function destroy(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincode->delete();

        return back();
    }

    public function massDestroy(MassDestroyPincodeRequest $request)
    {
        Pincode::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getPincode(Request $request)
    {
        $pincode = Pincode::find($request->id);
        if ($pincode) {
            $result = array('status' => true, 'msg' => 'Pincode found.', 'data' => $pincode);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addPincode(StorePincodeRequest $request)
    {
        $request->request->add(['status' => true]);
        $pincode = Pincode::create($request->all());
        if($pincode){
            $result = array('status'=> true, 'msg'=>'Pincode added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updatePincode(UpdatePincodeRequest $request)
    {
        $pincode = Pincode::find($request->id)->update($request->all());
        if($pincode){
            $result = array('status'=> true, 'msg'=>'Pincode updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function getPincodesAndAreasByBlock(Request $request)
    {
        $pincodes = Pincode::whereBlockId($request->blockId)->whereStatus(1)->get();
        $data = [];
        foreach ($pincodes as $pincode)
        {
            $data[] = [
                'id' => $pincode->id,
                'pincode' => $pincode->pincode,
                'areas' => Area::wherePincodeId($pincode->id)->whereStatus(true)->get(),
            ];
        }

        $result = array('status' => true, 'msg' => 'Pincode data.', 'data' => $data);
        return json_encode($result);
    }
}
