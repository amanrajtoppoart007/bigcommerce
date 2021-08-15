<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderItem;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Controllers\Traits\MediaUploadingTrait;


use Validator;
class SliderController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'images.*' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput();
        }

        $slider = new Slider();
        $slider->name = $request->name;
//        $slider->location = '/public/slider/';
        $slider->save();

        foreach ($request->input('images', []) as $file) {
            $slider->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

//        foreach ($request->images as $file) {
//            $name = strtotime('now') . '_slider_'. rand(00001, 9999) . '.' . $file->extension();
//            $file->storeAs('/public/slider/', $name);
//            $sliderItem = new SliderItem();
//            $sliderItem->slider_id = $slider->id;
//            $sliderItem->image = $name;
//            $sliderItem->save();
//        }
        return redirect()->route('admin.sliders.index');
    }

    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }
}
