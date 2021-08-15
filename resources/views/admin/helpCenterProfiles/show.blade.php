@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.helpCenterProfile.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.help-center-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.id') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.help_center') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->help_center->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_name') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.gst_number') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->gst_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_name') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_designation') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.email') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.primary_contact') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->primary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.secondary_contact') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->secondary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.work_area') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->work_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_address') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_street') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_address_line_two') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_state') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_district') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_city') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.organization_pincode') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->organization_pincode->pincode ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_address') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_street') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_address_line_two') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_state') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_district') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_city') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.representative_pincode') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->representative_pincode->pincode ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.image') }}
                        </th>
                        <td>
                            @if($helpCenterProfile->image)
                                <a href="{{ $helpCenterProfile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $helpCenterProfile->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.aadhaar_card') }}
                        </th>
                        <td>
                            @if($helpCenterProfile->aadhaar_card)
                                <a href="{{ $helpCenterProfile->aadhaar_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.pan_card') }}
                        </th>
                        <td>
                            @if($helpCenterProfile->pan_card)
                                <a href="{{ $helpCenterProfile->pan_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.address_proof') }}
                        </th>
                        <td>
                            @if($helpCenterProfile->address_proof)
                                <a href="{{ $helpCenterProfile->address_proof->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.registration_fees') }}
                        </th>
                        <td>
                            {{ $helpCenterProfile->registration_fees }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.payment_method') }}
                        </th>
                        <td>
                            {{ App\Models\HelpCenterProfile::PAYMENT_METHOD_RADIO[$helpCenterProfile->payment_method] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenterProfile.fields.signature') }}
                        </th>
                        <td>
                            @if($helpCenterProfile->signature)
                                <a href="{{ $helpCenterProfile->signature->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.help-center-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
