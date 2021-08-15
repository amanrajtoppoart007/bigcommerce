<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePincodeRequest;
use App\Http\Requests\UpdatePincodeRequest;
use App\Http\Resources\Admin\PincodeResource;
use App\Models\Pincode;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PincodeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pincode_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PincodeResource(Pincode::with(['block'])->get());
    }

    public function store(StorePincodeRequest $request)
    {
        $pincode = Pincode::create($request->all());

        return (new PincodeResource($pincode))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PincodeResource($pincode->load(['block']));
    }

    public function update(UpdatePincodeRequest $request, Pincode $pincode)
    {
        $pincode->update($request->all());

        return (new PincodeResource($pincode))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pincode $pincode)
    {
        abort_if(Gate::denies('pincode_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pincode->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
