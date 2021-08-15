<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyLogisticRequest;
use App\Http\Requests\StoreLogisticRequest;
use App\Http\Requests\UpdateLogisticRequest;
use App\Models\Logistic;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LogisticsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('logistic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Logistic::query()->select(sprintf('%s.*', (new Logistic)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'logistic_show';
                $editGate      = 'logistic_edit';
                $deleteGate    = 'logistic_delete';
                $crudRoutePart = 'logistics';

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
            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'approved', 'verified',]);

            return $table->make(true);
        }

        return view('admin.logistics.index');
    }

    public function create()
    {
        abort_if(Gate::denies('logistic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logistics.create');
    }

    public function store(StoreLogisticRequest $request)
    {
        $request->request->set('password', Hash::make($request->password));
        $request->request->set('approved', true);
        $request->request->set('verified', true);
        $request->request->set('verified_at', now());
        $logistic = Logistic::create($request->all());

        return redirect()->route('admin.logistics.index');
    }

    public function edit(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logistics.edit', compact('logistic'));
    }

    public function update(UpdateLogisticRequest $request, Logistic $logistic)
    {
        if($request->password){
            $request->request->set('password', Hash::make($request->password));
        }else{
            $request->request->set('password', $logistic->password);
        }
        $logistic->update($request->all());

        return redirect()->route('admin.logistics.index');
    }

    public function show(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logistics.show', compact('logistic'));
    }

    public function destroy(Logistic $logistic)
    {
        abort_if(Gate::denies('logistic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logistic->delete();

        return back();
    }

    public function massDestroy(MassDestroyLogisticRequest $request)
    {
        Logistic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
