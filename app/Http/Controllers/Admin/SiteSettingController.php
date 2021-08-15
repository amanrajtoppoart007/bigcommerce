<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteSettingController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::first();
        return view('admin.siteSetting.index', compact('siteSetting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'about_us' => 'nullable',
            't_and_c' => 'nullable',
            'privacy_policy' => 'nullable',
        ]);

        $siteSetting = new SiteSetting();
        $siteSetting->about_us = $request->about_us;
        $siteSetting->t_and_c = $request->t_and_c;
        $siteSetting->privacy_policy = $request->privacy_policy;

        if($siteSetting->save()){
            return redirect()->route('admin.home');
        }
        return back()->withInput()->withErrors();
    }

    public function update(Request $request, SiteSetting $siteSetting)
    {
        $request->validate([
            'about_us' => 'nullable',
            't_and_c' => 'nullable',
            'privacy_policy' => 'nullable',
        ]);

        $siteSetting->about_us = $request->about_us;
        $siteSetting->t_and_c = $request->t_and_c;
        $siteSetting->privacy_policy = $request->privacy_policy;

        if($siteSetting->save()){
            return redirect()->route('admin.home');
        }
        return back()->withInput()->withErrors();
    }

    public function storeCKEditorImages(Request $request)
    {
        $model         = new SiteSetting();
        $model->id     = $request->input('crud_id', 1);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
