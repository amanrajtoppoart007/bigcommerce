<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCropRequest;
use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Models\Crop;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CropController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crops = Crop::with(['media'])->get();

        return view('frontend.crops.index', compact('crops'));
    }

    public function create()
    {
        abort_if(Gate::denies('crop_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.crops.create');
    }

    public function store(StoreCropRequest $request)
    {
        $crop = Crop::create($request->all());

        if ($request->input('image', false)) {
            $crop->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $crop->id]);
        }

        return redirect()->route('frontend.crops.index');
    }

    public function edit(Crop $crop)
    {
        abort_if(Gate::denies('crop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.crops.edit', compact('crop'));
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

        return redirect()->route('frontend.crops.index');
    }

    public function show(Crop $crop)
    {
        abort_if(Gate::denies('crop_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.crops.show', compact('crop'));
    }

    public function destroy(Crop $crop)
    {
        abort_if(Gate::denies('crop_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crop->delete();

        return back();
    }

    public function massDestroy(MassDestroyCropRequest $request)
    {
        Crop::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('crop_create') && Gate::denies('crop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Crop();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
