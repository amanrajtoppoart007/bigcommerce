<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFranchiseeRequest;
use App\Http\Requests\StoreFranchiseeRequest;
use App\Http\Requests\UpdateFranchiseeRequest;
use App\Models\Franchisee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FranchiseeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('franchisee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisees = Franchisee::all();

        return view('frontend.franchisees.index', compact('franchisees'));
    }

    public function create()
    {
        abort_if(Gate::denies('franchisee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.franchisees.create');
    }

    public function store(StoreFranchiseeRequest $request)
    {
        $franchisee = Franchisee::create($request->all());

        return redirect()->route('frontend.franchisees.index');
    }

    public function edit(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.franchisees.edit', compact('franchisee'));
    }

    public function update(UpdateFranchiseeRequest $request, Franchisee $franchisee)
    {
        $franchisee->update($request->all());

        return redirect()->route('frontend.franchisees.index');
    }

    public function show(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.franchisees.show', compact('franchisee'));
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
