<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Http\Resources\Admin\CropResource;
use App\Models\Crop;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CropApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CropResource(Crop::all());
    }

    public function store(StoreCropRequest $request)
    {
        $crop = Crop::create($request->all());

        if ($request->input('image', false)) {
            $crop->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new CropResource($crop))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Crop $crop)
    {
        abort_if(Gate::denies('crop_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CropResource($crop);
    }

    public function update(UpdateCropRequest $request, Crop $crop)
    {
        $crop->update($request->all());

        if ($request->input('image', false)) {
            if (!$crop->image || $request->input('image') !== $crop->image->file_name) {
                if ($crop->image) {
                    $crop->image->delete();
                }

                $crop->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($crop->image) {
            $crop->image->delete();
        }

        return (new CropResource($crop))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Crop $crop)
    {
        abort_if(Gate::denies('crop_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crop->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
