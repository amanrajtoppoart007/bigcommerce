<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyHelpCenterRequest;
use App\Http\Requests\StoreHelpCenterRequest;
use App\Http\Requests\UpdateHelpCenterRequest;
use App\Models\HelpCenter;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HelpCenterController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('help_center_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenters = HelpCenter::all();

        return view('frontend.helpCenters.index', compact('helpCenters'));
    }

    public function create()
    {
        abort_if(Gate::denies('help_center_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.helpCenters.create');
    }

    public function store(StoreHelpCenterRequest $request)
    {
        $helpCenter = HelpCenter::create($request->all());

        return redirect()->route('frontend.help-centers.index');
    }

    public function edit(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.helpCenters.edit', compact('helpCenter'));
    }

    public function update(UpdateHelpCenterRequest $request, HelpCenter $helpCenter)
    {
        $helpCenter->update($request->all());

        return redirect()->route('frontend.help-centers.index');
    }

    public function show(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.helpCenters.show', compact('helpCenter'));
    }

    public function destroy(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenter->delete();

        return back();
    }

    public function massDestroy(MassDestroyHelpCenterRequest $request)
    {
        HelpCenter::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
