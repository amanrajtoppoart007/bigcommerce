<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAdminRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Admin::where('id', "<>", auth()->user()->id)->with(['roles'])->select(sprintf('%s.*', (new Admin)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'admin_show';
                $editGate      = 'admin_edit';
                $deleteGate    = 'admin_delete';
                $crudRoutePart = 'admins';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->addColumn('role_title', function ($row) {
                return $row->role ? $row->role->title : '';
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->verified ? 'checked' : null) . '>';
            });

            $table->editColumn('verification_token', function ($row) {
                return $row->verification_token ? $row->verification_token : "";
            });
            $table->editColumn('remember_token', function ($row) {
                return $row->remember_token ? $row->remember_token : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'role', 'approved', 'verified']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('admin.admins.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.admins.create', compact('roles'));
    }

    public function store(StoreAdminRequest $request)
    {
        $request->request->set('password', Hash::make($request->password));
        $admin = Admin::create($request->all());
        $admin->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.admins.index');
    }

    public function edit(Admin $admin)
    {
        abort_if(Gate::denies('admin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $admin->load('roles');

        return view('admin.admins.edit', compact('roles', 'admin'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        if($request->password){
            $request->request->set('password', Hash::make($request->password));
        }else{
            $request->request->set('password', $admin->password);
        }
        $admin->update($request->all());

        return redirect()->route('admin.admins.index');
    }

    public function show(Admin $admin)
    {
        abort_if(Gate::denies('admin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->load('roles');

        return view('admin.admins.show', compact('admin'));
    }

    public function destroy(Admin $admin)
    {
        abort_if(Gate::denies('admin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminRequest $request)
    {
        Admin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
