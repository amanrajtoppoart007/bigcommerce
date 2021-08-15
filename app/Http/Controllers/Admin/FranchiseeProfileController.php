<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFranchiseeProfileRequest;
use App\Http\Requests\StoreFranchiseeProfileRequest;
use App\Http\Requests\UpdateFranchiseeProfileRequest;
use App\Models\Block;
use App\Models\City;
use App\Models\District;
use App\Models\Franchisee;
use App\Models\FranchiseeProfile;
use App\Models\Pincode;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FranchiseeProfileController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('franchisee_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FranchiseeProfile::with(['franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city'])->select(sprintf('%s.*', (new FranchiseeProfile)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'franchisee_profile_show';
                $editGate      = 'franchisee_profile_edit';
                $deleteGate    = 'franchisee_profile_delete';
                $crudRoutePart = 'franchisee-profiles';

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
            $table->addColumn('franchisee_name', function ($row) {
                return $row->franchisee ? $row->franchisee->name : '';
            });

            $table->editColumn('organization_name', function ($row) {
                return $row->organization_name ? $row->organization_name : "";
            });
            $table->editColumn('gst_number', function ($row) {
                return $row->gst_number ? $row->gst_number : "";
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
            $table->editColumn('organization_address', function ($row) {
                return $row->organization_address ? $row->organization_address : "";
            });
            $table->addColumn('organization_district_name', function ($row) {
                return $row->organization_district ? $row->organization_district->name : '';
            });

            $table->addColumn('organization_city_city_name', function ($row) {
                return $row->organization_city ? $row->organization_city->city_name : '';
            });

            $table->addColumn('representative_district_name', function ($row) {
                return $row->representative_district ? $row->representative_district->name : '';
            });

            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
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
            $table->editColumn('address_proof', function ($row) {
                return $row->address_proof ? '<a href="' . $row->address_proof->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('registration_fees', function ($row) {
                return $row->registration_fees ? $row->registration_fees : "";
            });
            $table->editColumn('payment_method', function ($row) {
                return $row->payment_method ? FranchiseeProfile::PAYMENT_METHOD_RADIO[$row->payment_method] : '';
            });
            $table->editColumn('signature', function ($row) {
                return $row->signature ? '<a href="' . $row->signature->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'franchisee', 'organization_district', 'organization_city', 'representative_district', 'image', 'aadhaar_card', 'pan_card', 'address_proof', 'signature']);

            return $table->make(true);
        }

        $franchisees = Franchisee::get();
        $states      = State::get();
        $districts   = District::get();
        $cities      = City::get();

        return view('admin.franchiseeProfiles.index', compact('franchisees', 'states', 'districts', 'cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('franchisee_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.franchiseeProfiles.create', compact('franchisees', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'pincodes'));
    }

    public function store(StoreFranchiseeProfileRequest $request)
    {
        $franchiseeProfile = FranchiseeProfile::create($request->all());

        if ($request->input('image', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('aadhaar_card', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('address_proof', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
        }

        if ($request->input('signature', false)) {
            $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $franchiseeProfile->id]);
        }

        return redirect()->route('admin.franchisee-profiles.index');
    }

    public function edit(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchisees = Franchisee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $franchiseeProfile->load('franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('admin.franchiseeProfiles.edit', compact('franchisees', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'franchiseeProfile', 'pincodes'));
    }

    public function update(UpdateFranchiseeProfileRequest $request, FranchiseeProfile $franchiseeProfile)
    {
        $franchiseeProfile->update($request->all());

        if ($request->input('image', false)) {
            if (!$franchiseeProfile->image || $request->input('image') !== $franchiseeProfile->image->file_name) {
                if ($franchiseeProfile->image) {
                    $franchiseeProfile->image->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($franchiseeProfile->image) {
            $franchiseeProfile->image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$franchiseeProfile->aadhaar_card || $request->input('aadhaar_card') !== $franchiseeProfile->aadhaar_card->file_name) {
                if ($franchiseeProfile->aadhaar_card) {
                    $franchiseeProfile->aadhaar_card->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($franchiseeProfile->aadhaar_card) {
            $franchiseeProfile->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$franchiseeProfile->pan_card || $request->input('pan_card') !== $franchiseeProfile->pan_card->file_name) {
                if ($franchiseeProfile->pan_card) {
                    $franchiseeProfile->pan_card->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($franchiseeProfile->pan_card) {
            $franchiseeProfile->pan_card->delete();
        }

        if ($request->input('address_proof', false)) {
            if (!$franchiseeProfile->address_proof || $request->input('address_proof') !== $franchiseeProfile->address_proof->file_name) {
                if ($franchiseeProfile->address_proof) {
                    $franchiseeProfile->address_proof->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }
        } elseif ($franchiseeProfile->address_proof) {
            $franchiseeProfile->address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$franchiseeProfile->signature || $request->input('signature') !== $franchiseeProfile->signature->file_name) {
                if ($franchiseeProfile->signature) {
                    $franchiseeProfile->signature->delete();
                }

                $franchiseeProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($franchiseeProfile->signature) {
            $franchiseeProfile->signature->delete();
        }

        return redirect()->route('admin.franchisee-profiles.index');
    }

    public function show(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfile->load('franchisee', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('admin.franchiseeProfiles.show', compact('franchiseeProfile'));
    }

    public function destroy(FranchiseeProfile $franchiseeProfile)
    {
        abort_if(Gate::denies('franchisee_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $franchiseeProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyFranchiseeProfileRequest $request)
    {
        FranchiseeProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('franchisee_profile_create') && Gate::denies('franchisee_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FranchiseeProfile();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function checkFranchiseeProfile(Request $request)
    {
        $franchisee = Franchisee::find($request->franchiseeId);
        if(isset($franchisee->profile)){
            return response([
                'status' => true,
                'message' => 'exists.'
            ]);
        }
        return response([
            'status' => false,
            'message' => 'Does not exists.'
        ]);
    }
}
