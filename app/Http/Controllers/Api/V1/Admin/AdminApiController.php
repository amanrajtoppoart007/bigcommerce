<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminResource(Admin::with(['role'])->get());
    }

    public function store(StoreAdminRequest $request)
    {
        $admin = Admin::create($request->all());

        return (new AdminResource($admin))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Admin $admin)
    {
        abort_if(Gate::denies('admin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminResource($admin->load(['role']));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $admin->update($request->all());

        return (new AdminResource($admin))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Admin $admin)
    {
        abort_if(Gate::denies('admin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
