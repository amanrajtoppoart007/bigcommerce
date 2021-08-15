@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.franchiseeProfile.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.franchisee-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.id') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.franchisee') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->franchisee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_name') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.gst_number') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->gst_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_name') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_designation') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.email') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.primary_contact') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->primary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.secondary_contact') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->secondary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.work_area') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->work_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_address') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_street') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_address_line_two') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_state') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_district') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_city') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_city->city_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.organization_pincode') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->organization_pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_address') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_street') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_address_line_two') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_state') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_district') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_city') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_city->city_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.representative_pincode') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->representative_pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.image') }}
                        </th>
                        <td>
                            @if($franchiseeProfile->image)
                                <a href="{{ $franchiseeProfile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $franchiseeProfile->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.aadhaar_card') }}
                        </th>
                        <td>
                            @if($franchiseeProfile->aadhaar_card)
                                <a href="{{ $franchiseeProfile->aadhaar_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.pan_card') }}
                        </th>
                        <td>
                            @if($franchiseeProfile->pan_card)
                                <a href="{{ $franchiseeProfile->pan_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.address_proof') }}
                        </th>
                        <td>
                            @if($franchiseeProfile->address_proof)
                                <a href="{{ $franchiseeProfile->address_proof->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.registration_fees') }}
                        </th>
                        <td>
                            {{ $franchiseeProfile->registration_fees }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.payment_method') }}
                        </th>
                        <td>
                            {{ App\Models\FranchiseeProfile::PAYMENT_METHOD_RADIO[$franchiseeProfile->payment_method] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchiseeProfile.fields.signature') }}
                        </th>
                        <td>
                            @if($franchiseeProfile->signature)
                                <a href="{{ $franchiseeProfile->signature->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.franchisee-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection