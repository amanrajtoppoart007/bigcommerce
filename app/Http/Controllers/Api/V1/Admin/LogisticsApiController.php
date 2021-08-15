<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogisticRequest;
use App\Http\Requests\UpdateLogisticRequest;
use App\Http\Resources\Admin\LogisticResource;
use App\Models\Logistic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogisticsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('logistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogisticResource(Logistic::all());
    }

    public function store(StoreLogisticRequest $request)
    {
        $logistic = Logistic::create($request->all());

        return (new LogisticResource($logistic))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogisticResource($logistic);
    }

    public function update(UpdateLogisticRequest $request, Logistic $logistic)
    {
        $logistic->update($request->all());

        return (new LogisticResource($logistic))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logistic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
