<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFollowerRequest;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;
use App\Models\Follower;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowerController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('follower_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followers = Follower::with(['user', 'follow'])->get();

        $users = User::get();

        return view('frontend.followers.index', compact('followers', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('follower_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follows = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.followers.create', compact('users', 'follows'));
    }

    public function store(StoreFollowerRequest $request)
    {
        $follower = Follower::create($request->all());

        return redirect()->route('frontend.followers.index');
    }

    public function edit(Follower $follower)
    {
        abort_if(Gate::denies('follower_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follows = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follower->load('user', 'follow');

        return view('frontend.followers.edit', compact('users', 'follows', 'follower'));
    }

    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        $follower->update($request->all());

        return redirect()->route('frontend.followers.index');
    }

    public function show(Follower $follower)
    {
        abort_if(Gate::denies('follower_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->load('user', 'follow');

        return view('frontend.followers.show', compact('follower'));
    }

    public function destroy(Follower $follower)
    {
        abort_if(Gate::denies('follower_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->delete();

        return back();
    }

    public function massDestroy(MassDestroyFollowerRequest $request)
    {
        Follower::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
