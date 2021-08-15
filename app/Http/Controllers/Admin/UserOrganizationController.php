<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserOrganizationRequest;
use App\Http\Requests\StoreUserOrganizationRequest;
use App\Http\Requests\UpdateUserOrganizationRequest;
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\User;
use App\Models\UserOrganization;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserOrganizationController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_organization_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserOrganization::with(['user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state'])->select(sprintf('%s.*', (new UserOrganization)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_organization_show';
                $editGate      = 'user_organization_edit';
                $deleteGate    = 'user_organization_delete';
                $crudRoutePart = 'user-organizations';

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
            $table->editColumn('gst_number', function ($row) {
                return $row->gst_number ? $row->gst_number : "";
            });
            $table->editColumn('organization_name', function ($row) {
                return $row->organization_name ? $row->organization_name : "";
            });
            $table->editColumn('representative_name', function ($row) {
                return $row->representative_name ? $row->representative_name : "";
            });
            $table->editColumn('representative_designation', function ($row) {
                return $row->representative_designation ? $row->representative_designation : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('primary_contact', function ($row) {
                return $row->primary_contact ? $row->primary_contact : "";
            });
            $table->editColumn('work_area', function ($row) {
                return $row->work_area ? $row->work_area : "";
            });
            $table->editColumn('representative_image', function ($row) {
                if ($photo = $row->representative_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('aadhaar_card', function ($row) {
                return $row->aadhaar_card ? '<a href="' . $row->aadhaar_card->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('pan_card', function ($row) {
                return $row->pan_card ? '<a href="' . $row->pan_card->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('organization_address_proof', function ($row) {
                return $row->organization_address_proof ? '<a href="' . $row->organization_address_proof->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('amount_deposited_method', function ($row) {
                return $row->amount_deposited_method ? $row->amount_deposited_method : "";
            });
            $table->editColumn('amount_deposited', function ($row) {
                return $row->amount_deposited ? $row->amount_deposited : "";
            });
            $table->editColumn('signature', function ($row) {
                if ($photo = $row->signature) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('organization_address_line_two', function ($row) {
                return $row->organization_address_line_two ? $row->organization_address_line_two : "";
            });
            $table->addColumn('organization_district_name', function ($row) {
                return $row->organization_district ? $row->organization_district->name : '';
            });

            $table->addColumn('organization_city_city_name', function ($row) {
                return $row->organization_city ? $row->organization_city->city_name : '';
            });

            $table->editColumn('organization_pincode', function ($row) {
                return $row->organization_pincode ? $row->organization_pincode : "";
            });
            $table->editColumn('representative_address_line_two', function ($row) {
                return $row->representative_address_line_two ? $row->representative_address_line_two : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'representative_image', 'aadhaar_card', 'pan_card', 'organization_address_proof', 'signature', 'user', 'organization_district', 'organization_city']);

            return $table->make(true);
        }

        $users     = User::get();
        $districts = District::get();
        $cities    = City::get();
        $states    = State::get();

        return view('admin.userOrganizations.index', compact('users', 'districts', 'cities', 'states'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_organization_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userOrganizations.create', compact('users', 'organization_districts', 'organization_cities', 'organization_states', 'representative_districts', 'representative_cities', 'representative_states'));
    }

    public function store(StoreUserOrganizationRequest $request)
    {
        $userOrganization = UserOrganization::create($request->all());

        if ($request->input('representative_image', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('representative_image')))->toMediaCollection('representative_image');
        }

        if ($request->input('aadhaar_card', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('organization_address_proof', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('organization_address_proof')))->toMediaCollection('organization_address_proof');
        }

        if ($request->input('signature', false)) {
            $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $userOrganization->id]);
        }

        return redirect()->route('admin.user-organizations.index');
    }

    public function edit(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = City::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userOrganization->load('user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state');

        return view('admin.userOrganizations.edit', compact('users', 'organization_districts', 'organization_cities', 'organization_states', 'representative_districts', 'representative_cities', 'representative_states', 'userOrganization'));
    }

    public function update(UpdateUserOrganizationRequest $request, UserOrganization $userOrganization)
    {
        $userOrganization->update($request->all());

        if ($request->input('representative_image', false)) {
            if (!$userOrganization->representative_image || $request->input('representative_image') !== $userOrganization->representative_image->file_name) {
                if ($userOrganization->representative_image) {
                    $userOrganization->representative_image->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('representative_image')))->toMediaCollection('representative_image');
            }
        } elseif ($userOrganization->representative_image) {
            $userOrganization->representative_image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$userOrganization->aadhaar_card || $request->input('aadhaar_card') !== $userOrganization->aadhaar_card->file_name) {
                if ($userOrganization->aadhaar_card) {
                    $userOrganization->aadhaar_card->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($userOrganization->aadhaar_card) {
            $userOrganization->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$userOrganization->pan_card || $request->input('pan_card') !== $userOrganization->pan_card->file_name) {
                if ($userOrganization->pan_card) {
                    $userOrganization->pan_card->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($userOrganization->pan_card) {
            $userOrganization->pan_card->delete();
        }

        if ($request->input('organization_address_proof', false)) {
            if (!$userOrganization->organization_address_proof || $request->input('organization_address_proof') !== $userOrganization->organization_address_proof->file_name) {
                if ($userOrganization->organization_address_proof) {
                    $userOrganization->organization_address_proof->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('organization_address_proof')))->toMediaCollection('organization_address_proof');
            }
        } elseif ($userOrganization->organization_address_proof) {
            $userOrganization->organization_address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$userOrganization->signature || $request->input('signature') !== $userOrganization->signature->file_name) {
                if ($userOrganization->signature) {
                    $userOrganization->signature->delete();
                }

                $userOrganization->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($userOrganization->signature) {
            $userOrganization->signature->delete();
        }

        return redirect()->route('admin.user-organizations.index');
    }

    public function show(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganization->load('user', 'organization_district', 'organization_city', 'organization_state', 'representative_district', 'representative_city', 'representative_state');

        return view('admin.userOrganizations.show', compact('userOrganization'));
    }

    public function destroy(UserOrganization $userOrganization)
    {
        abort_if(Gate::denies('user_organization_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userOrganization->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserOrganizationRequest $request)
    {
        UserOrganization::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_organization_create') && Gate::denies('user_organization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UserOrganization();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
