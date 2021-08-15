@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userOrganization.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-organizations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.id') }}
                        </th>
                        <td>
                            {{ $userOrganization->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.user') }}
                        </th>
                        <td>
                            {{ $userOrganization->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.gst_number') }}
                        </th>
                        <td>
                            {{ $userOrganization->gst_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_name') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_name') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_designation') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.email') }}
                        </th>
                        <td>
                            {{ $userOrganization->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.primary_contact') }}
                        </th>
                        <td>
                            {{ $userOrganization->primary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.secondary_contact') }}
                        </th>
                        <td>
                            {{ $userOrganization->secondary_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.work_area') }}
                        </th>
                        <td>
                            {{ $userOrganization->work_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.amount_deposited_method') }}
                        </th>
                        <td>
                            {{ $userOrganization->amount_deposited_method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.amount_deposited') }}
                        </th>
                        <td>
                            {{ $userOrganization->amount_deposited }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_address') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_street') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_address_line_two') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_district') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_city') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_city->city_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_state') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_pincode') }}
                        </th>
                        <td>
                            {{ $userOrganization->organization_pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_address') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_street') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_address_line_two') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_address_line_two }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_district') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_city') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_city->city_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_state') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_pincode') }}
                        </th>
                        <td>
                            {{ $userOrganization->representative_pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.representative_image') }}
                        </th>
                        <td>
                            @if($userOrganization->representative_image)
                                <a href="{{ $userOrganization->representative_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $userOrganization->representative_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.aadhaar_card') }}
                        </th>
                        <td>
                            @if($userOrganization->aadhaar_card)
                                <a href="{{ $userOrganization->aadhaar_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.pan_card') }}
                        </th>
                        <td>
                            @if($userOrganization->pan_card)
                                <a href="{{ $userOrganization->pan_card->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.organization_address_proof') }}
                        </th>
                        <td>
                            @if($userOrganization->organization_address_proof)
                                <a href="{{ $userOrganization->organization_address_proof->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userOrganization.fields.signature') }}
                        </th>
                        <td>
                            @if($userOrganization->signature)
                                <a href="{{ $userOrganization->signature->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $userOrganization->signature->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-organizations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection