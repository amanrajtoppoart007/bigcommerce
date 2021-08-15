<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHelpCenterProfileRequest;
use App\Http\Requests\StoreHelpCenterProfileRequest;
use App\Http\Requests\UpdateHelpCenterProfileRequest;
use App\Models\Block;
use App\Models\City;
use App\Models\District;
use App\Models\HelpCenter;
use App\Models\HelpCenterProfile;
use App\Models\Pincode;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HelpCenterProfileController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('help_center_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HelpCenterProfile::with(['help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city'])->select(sprintf('%s.*', (new HelpCenterProfile)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'help_center_profile_show';
                $editGate      = 'help_center_profile_edit';
                $deleteGate    = 'help_center_profile_delete';
                $crudRoutePart = 'help-center-profiles';

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
            $table->addColumn('help_center_name', function ($row) {
                return $row->help_center ? $row->help_center->name : '';
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
                return $row->organization_city ? $row->organization_city->name : '';
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
                return $row->payment_method ? HelpCenterProfile::PAYMENT_METHOD_RADIO[$row->payment_method] : '';
            });
            $table->editColumn('signature', function ($row) {
                return $row->signature ? '<a href="' . $row->signature->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'help_center', 'organization_district', 'organization_city', 'representative_district', 'image', 'aadhaar_card', 'pan_card', 'address_proof', 'signature']);

            return $table->make(true);
        }

        $help_centers = HelpCenter::get();
        $states       = State::get();
        $districts    = District::get();
        $blocks       = Block::get();

        return view('admin.helpCenterProfiles.index', compact('help_centers', 'states', 'districts', 'blocks'));
    }

    public function create()
    {
        abort_if(Gate::denies('help_center_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $help_centers = HelpCenter::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.helpCenterProfiles.create', compact('help_centers', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities' , 'pincodes'));
    }

    public function store(StoreHelpCenterProfileRequest $request)
    {
        $helpCenterProfile = HelpCenterProfile::create($request->all());

        if ($request->input('image', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('aadhaar_card', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
        }

        if ($request->input('pan_card', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
        }

        if ($request->input('address_proof', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
        }

        if ($request->input('signature', false)) {
            $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $helpCenterProfile->id]);
        }

        return redirect()->route('admin.help-center-profiles.index');
    }

    public function edit(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $help_centers = HelpCenter::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organization_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $representative_cities = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $helpCenterProfile->load('help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.helpCenterProfiles.edit', compact('help_centers', 'organization_states', 'organization_districts', 'organization_cities', 'representative_states', 'representative_districts', 'representative_cities', 'helpCenterProfile', 'pincodes'));
    }

    public function update(UpdateHelpCenterProfileRequest $request, HelpCenterProfile $helpCenterProfile)
    {
        $helpCenterProfile->update($request->all());

        if ($request->input('image', false)) {
            if (!$helpCenterProfile->image || $request->input('image') !== $helpCenterProfile->image->file_name) {
                if ($helpCenterProfile->image) {
                    $helpCenterProfile->image->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($helpCenterProfile->image) {
            $helpCenterProfile->image->delete();
        }

        if ($request->input('aadhaar_card', false)) {
            if (!$helpCenterProfile->aadhaar_card || $request->input('aadhaar_card') !== $helpCenterProfile->aadhaar_card->file_name) {
                if ($helpCenterProfile->aadhaar_card) {
                    $helpCenterProfile->aadhaar_card->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('aadhaar_card')))->toMediaCollection('aadhaar_card');
            }
        } elseif ($helpCenterProfile->aadhaar_card) {
            $helpCenterProfile->aadhaar_card->delete();
        }

        if ($request->input('pan_card', false)) {
            if (!$helpCenterProfile->pan_card || $request->input('pan_card') !== $helpCenterProfile->pan_card->file_name) {
                if ($helpCenterProfile->pan_card) {
                    $helpCenterProfile->pan_card->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('pan_card')))->toMediaCollection('pan_card');
            }
        } elseif ($helpCenterProfile->pan_card) {
            $helpCenterProfile->pan_card->delete();
        }

        if ($request->input('address_proof', false)) {
            if (!$helpCenterProfile->address_proof || $request->input('address_proof') !== $helpCenterProfile->address_proof->file_name) {
                if ($helpCenterProfile->address_proof) {
                    $helpCenterProfile->address_proof->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('address_proof')))->toMediaCollection('address_proof');
            }
        } elseif ($helpCenterProfile->address_proof) {
            $helpCenterProfile->address_proof->delete();
        }

        if ($request->input('signature', false)) {
            if (!$helpCenterProfile->signature || $request->input('signature') !== $helpCenterProfile->signature->file_name) {
                if ($helpCenterProfile->signature) {
                    $helpCenterProfile->signature->delete();
                }

                $helpCenterProfile->addMedia(storage_path('tmp/uploads/' . $request->input('signature')))->toMediaCollection('signature');
            }
        } elseif ($helpCenterProfile->signature) {
            $helpCenterProfile->signature->delete();
        }

        return redirect()->route('admin.help-center-profiles.index');
    }

    public function show(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfile->load('help_center', 'organization_state', 'organization_district', 'organization_city', 'representative_state', 'representative_district', 'representative_city');

        return view('admin.helpCenterProfiles.show', compact('helpCenterProfile'));
    }

    public function destroy(HelpCenterProfile $helpCenterProfile)
    {
        abort_if(Gate::denies('help_center_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helpCenterProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyHelpCenterProfileRequest $request)
    {
        HelpCenterProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('help_center_profile_create') && Gate::denies('help_center_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HelpCenterProfile();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function checkHelpCenterProfile(Request $request)
    {
        $helpCenter = HelpCenter::find($request->helpCenterId);
        if(isset($helpCenter->profile)){
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
