<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPincodeRequest;
use App\Http\Requests\StorePincodeRequest;
use App\Http\Requests\UpdatePincodeRequest;
use App\Models\Block;
use App\Models\Pincode;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PincodeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('pincode_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincodes = Pincode::with(['block'])->get();

        $blocks = Block::get();

        return view('frontend.pincodes.index', compact('pincodes', 'blocks'));
    }

    public function create()
    {
        abort_if(Gate::denies('pincode_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.pincodes.create', compact('blocks'));
    }

    public function store(StorePincodeRequest $request)
    {
        $pincode = Pincode::create($request->all());

        return redirect()->route('frontend.pincodes.index');
    }

    public function edit(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincode->load('block');

        return view('frontend.pincodes.edit', compact('blocks', 'pincode'));
    }

    public function update(UpdatePincodeRequest $request, Pincode $pincode)
    {
        $pincode->update($request->all());

        return redirect()->route('frontend.pincodes.index');
    }

    public function show(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincode->load('block', 'pincodeAreas', 'pincodeUserAddresses');

        return view('frontend.pincodes.show', compact('pincode'));
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
}
