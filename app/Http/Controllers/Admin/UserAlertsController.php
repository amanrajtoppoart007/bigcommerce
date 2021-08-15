<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserAlertRequest;
use App\Http\Requests\StoreUserAlertRequest;
use App\Http\Requests\UpdateUserAlertRequest;
use App\Models\User;
use App\Models\UserAlert;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserAlertsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_alert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserAlert::with(['users'])->select(sprintf('%s.*', (new UserAlert)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_alert_show';
                $editGate      = 'user_alert_edit';
                $deleteGate    = 'user_alert_delete';
                $crudRoutePart = 'user-alerts';

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
            $table->editColumn('alert_text', function ($row) {
                return $row->alert_text ? $row->alert_text : "";
            });
            $table->editColumn('alert_link', function ($row) {
                return $row->alert_link ? $row->alert_link : "";
            });
            $table->editColumn('user', function ($row) {
                $labels = [];

                foreach ($row->users as $user) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $user->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }
        $users = User::all()->pluck('name', 'id');
        return view('admin.userAlerts.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_alert_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id');

        return view('admin.userAlerts.create', compact('users'));
    }

    public function store(StoreUserAlertRequest $request)
    {
        $userAlert = UserAlert::create($request->all());
        $userAlert->users()->sync($request->input('users', []));

        return redirect()->route('admin.user-alerts.index');
    }

    public function show(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->load('users');

        return view('admin.userAlerts.show', compact('userAlert'));
    }

    public function destroy(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserAlertRequest $request)
    {
        UserAlert::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function read(Request $request)
    {
        $alerts = \Auth::user()->userUserAlerts()->where('read', false)->get();

        foreach ($alerts as $alert) {
            $pivot       = $alert->pivot;
            $pivot->read = true;
            $pivot->save();
        }
    }

    public function getUserAlert(Request $request)
    {
        $userAlert = UserAlert::find($request->id);
        if ($userAlert) {
            $result = array('status' => true, 'msg' => 'User Alert found.', 'data' => $userAlert);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addUserAlert(StoreUserAlertRequest $request)
    {
        $userAlert = UserAlert::create($request->all());
        if($userAlert){
            $result = array('status'=> true, 'msg'=>'User Alert added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updateUserAlert(UpdateUserAlertRequest $request)
    {
        $userAlert = UserAlert::find($request->id)->update($request->all());
        if($userAlert){
            $result = array('status'=> true, 'msg'=>'User Alert updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }
}
