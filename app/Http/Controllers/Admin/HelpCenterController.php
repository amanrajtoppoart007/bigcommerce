<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelpCenterRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyHelpCenterRequest;
use App\Http\Requests\StoreHelpCenterRequest;
use App\Http\Requests\UpdateHelpCenterRequest;
use App\Mail\HelpCenterWelcomeMessage;
use App\Models\HelpCenter;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HelpCenterController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('help_center_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HelpCenter::query()->select(sprintf('%s.*', (new HelpCenter)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'help_center_show';
                $editGate      = 'help_center_edit';
                $deleteGate    = 'help_center_delete';
                $crudRoutePart = 'help-centers';

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
            $table->editColumn('mobile', function ($row) {
                return $row->mobile ? $row->mobile : "";
            });
            $table->editColumn('role', function ($row) {
                return $row->role ? HelpCenter::ROLE_SELECT[$row->role] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.helpCenters.index');
    }

    public function create()
    {
        abort_if(Gate::denies('help_center_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helpCenters.create');
    }

    public function store(StoreHelpCenterRequest $request)
    {
       $request->validated();
       $input = $request->except(['password']);
       $input['password'] = Hash::make($request->input('password'));
       $request->request->add(['approved' => 1]);
       $request->request->add(['verified' => 1]);
       $request->request->add(['verified_at' => now()]);
       $helpCenter = HelpCenter::create($input);

//       if($helpCenter->id && $helpCenter->email)
//       {
//           Mail::to($helpCenter)->send(new HelpCenterWelcomeMessage());
//       }

        $data['name'] = $helpCenter->name;
        $data['email'] = $helpCenter->email;
        $data['username'] = $helpCenter->email;
        $data['password'] = request()->input('password');
        $data['mobile'] = $helpCenter->mobile;
        event(new HelpCenterRegistered($data));

        return redirect()->route('admin.help-centers.index');
    }

    public function edit(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helpCenters.edit', compact('helpCenter'));
    }

    public function update(UpdateHelpCenterRequest $request, HelpCenter $helpCenter)
    {
        $request->validated();
        $input = $request->except(['password']);
        if($request->has("password") && !empty($request->input('password')))
        {
         $input['password'] = Hash::make($request->input('password'));
        }
        $helpCenter->update($input);

        return redirect()->route('admin.help-centers.index');
    }

    public function show(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helpCenters.show', compact('helpCenter'));
    }

    public function destroy(HelpCenter $helpCenter)
    {
        abort_if(Gate::denies('help_center_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenter->delete();

        return back();
    }

    public function massDestroy(MassDestroyHelpCenterRequest $request)
    {
        HelpCenter::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
