<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class FollowerController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('follower_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Follower::with(['user', 'follow'])->select(sprintf('%s.*', (new Follower)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'follower_show';
                $editGate      = 'follower_edit';
                $deleteGate    = 'follower_delete';
                $crudRoutePart = 'followers';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('follow_name', function ($row) {
                return $row->follow ? $row->follow->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'follow']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.followers.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('follower_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follows = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.followers.create', compact('users', 'follows'));
    }

    public function store(StoreFollowerRequest $request)
    {
        $follower = Follower::create($request->all());

        return redirect()->route('admin.followers.index');
    }

    public function edit(Follower $follower)
    {
        abort_if(Gate::denies('follower_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follows = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follower->load('user', 'follow');

        return view('admin.followers.edit', compact('users', 'follows', 'follower'));
    }

    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        $follower->update($request->all());

        return redirect()->route('admin.followers.index');
    }

    public function show(Follower $follower)
    {
        abort_if(Gate::denies('follower_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->load('user', 'follow');

        return view('admin.followers.show', compact('follower'));
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
