<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use App\Http\Resources\Admin\BlockResource;
use App\Models\Block;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('block_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockResource(Block::with(['district'])->get());
    }

    public function store(StoreBlockRequest $request)
    {
        $block = Block::create($request->all());

        return (new BlockResource($block))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Block $block)
    {
        abort_if(Gate::denies('block_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockResource($block->load(['district']));
    }

    public function update(UpdateBlockRequest $request, Block $block)
    {
        $block->update($request->all());

        return (new BlockResource($block))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Block $block)
    {
        abort_if(Gate::denies('block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $block->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
