<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBlockRequest;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use App\Models\Block;
use App\Models\District;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BlockController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('block_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Block::with(['district'])->select(sprintf('%s.*', (new Block)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'block_show';
                $editGate      = 'block_edit';
                $deleteGate    = 'block_delete';
                $crudRoutePart = 'blocks';

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
            $table->addColumn('district_name', function ($row) {
                return $row->district ? $row->district->name : '';
            });

            $table->editColumn('status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->status ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'district', 'status']);

            return $table->make(true);
        }

        $districts = District::get();

        return view('admin.blocks.index', compact('districts'));
    }

    public function create()
    {
        abort_if(Gate::denies('block_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.blocks.create', compact('districts'));
    }

    public function store(StoreBlockRequest $request)
    {
        $block = Block::create($request->all());

        return redirect()->route('admin.blocks.index');
    }

    public function edit(Block $block)
    {
        abort_if(Gate::denies('block_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $block->load('district');

        return view('admin.blocks.edit', compact('districts', 'block'));
    }

    public function update(UpdateBlockRequest $request, Block $block)
    {
        $request->request->add(['status' => $request->boolean('status')]);
        $block->update($request->all());

        return redirect()->route('admin.blocks.index');
    }

    public function show(Block $block)
    {
        abort_if(Gate::denies('block_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $block->load('district', 'blockPincodes');

        return view('admin.blocks.show', compact('block'));
    }

    public function destroy(Block $block)
    {
        abort_if(Gate::denies('block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $block->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlockRequest $request)
    {
        Block::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getBlock(Request $request)
    {
        $block = Block::find($request->id);
        if ($block) {
            $result = array('status' => true, 'msg' => 'Block found.', 'data' => $block);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addBlock(StoreBlockRequest $request)
    {
        $request->request->add(['status' => true]);
        $block = Block::create($request->all());
        if($block){
            $result = array('status'=> true, 'msg'=>'Block added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updateBlock(UpdateBlockRequest $request)
    {
        $block = Block::find($request->id)->update($request->all());
        if($block){
            $result = array('status'=> true, 'msg'=>'Block updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function getBlockByDistrict(Request $request)
    {
        $blocks = Block::whereDistrictId($request->districtId)->whereStatus(true)->get();
        $result = array('status' => true, 'msg' => 'Block data.', 'data' => $blocks);
        return json_encode($result);
    }
}
