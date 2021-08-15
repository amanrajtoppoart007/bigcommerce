<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFranchiseeRequest;
use App\Http\Requests\UpdateFranchiseeRequest;
use App\Http\Resources\Admin\FranchiseeResource;
use App\Models\Franchisee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FranchiseeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('franchisee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FranchiseeResource(Franchisee::all());
    }

    public function store(StoreFranchiseeRequest $request)
    {
        $franchisee = Franchisee::create($request->all());

        return (new FranchiseeResource($franchisee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FranchiseeResource($franchisee);
    }

    public function update(UpdateFranchiseeRequest $request, Franchisee $franchisee)
    {
        $franchisee->update($request->all());

        return (new FranchiseeResource($franchisee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Franchisee $franchisee)
    {
        abort_if(Gate::denies('franchisee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
