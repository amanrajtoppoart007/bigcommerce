<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyLogisticRequest;
use App\Http\Requests\StoreLogisticRequest;
use App\Http\Requests\UpdateLogisticRequest;
use App\Models\Logistic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogisticsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('logistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logistics = Logistic::all();

        return view('frontend.logistics.index', compact('logistics'));
    }

    public function create()
    {
        abort_if(Gate::denies('logistic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.logistics.create');
    }

    public function store(StoreLogisticRequest $request)
    {
        $logistic = Logistic::create($request->all());

        return redirect()->route('frontend.logistics.index');
    }

    public function edit(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.logistics.edit', compact('logistic'));
    }

    public function update(UpdateLogisticRequest $request, Logistic $logistic)
    {
        $logistic->update($request->all());

        return redirect()->route('frontend.logistics.index');
    }

    public function show(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.logistics.show', compact('logistic'));
    }

    public function destroy(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logistic->delete();

        return back();
    }

    public function massDestroy(MassDestroyLogisticRequest $request)
    {
        Logistic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
