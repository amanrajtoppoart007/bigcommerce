<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelpCenterRequest;
use App\Http\Requests\UpdateHelpCenterRequest;
use App\Http\Resources\Admin\HelpCenterResource;
use App\Models\HelpCenter;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HelpCenterApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('help_center_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HelpCenterResource(HelpCenter::all());
    }

    public function store(StoreHelpCenterRequest $request)
    {
        $helpCenter = HelpCenter::create($request->all());

        return (new HelpCenterResource($helpCenter))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HelpCenterResource($helpCenter);
    }

    public function update(UpdateHelpCenterRequest $request, HelpCenter $helpCenter)
    {
        $helpCenter->update($request->all());

        return (new HelpCenterResource($helpCenter))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenter->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
