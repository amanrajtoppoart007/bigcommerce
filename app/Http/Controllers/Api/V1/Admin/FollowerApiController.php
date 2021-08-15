<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;
use App\Http\Resources\Admin\FollowerResource;
use App\Models\Follower;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follower_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowerResource(Follower::with(['user', 'follow'])->get());
    }

    public function store(StoreFollowerRequest $request)
    {
        $follower = Follower::create($request->all());

        return (new FollowerResource($follower))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Follower $follower)
    {
        abort_if(Gate::denies('follower_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowerResource($follower->load(['user', 'follow']));
    }

    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        $follower->update($request->all());

        return (new FollowerResource($follower))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Follower $follower)
    {
        abort_if(Gate::denies('follower_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
