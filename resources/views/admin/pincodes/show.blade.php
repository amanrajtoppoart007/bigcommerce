@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pincode.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pincodes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pincode.fields.id') }}
                        </th>
                        <td>
                            {{ $pincode->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pincode.fields.pincode') }}
                        </th>
                        <td>
                            {{ $pincode->pincode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pincode.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pincode->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pincode.fields.block') }}
                        </th>
                        <td>
                            {{ $pincode->block->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pincodes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#pincode_areas" role="tab" data-toggle="tab">
                {{ trans('cruds.area.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#pincode_user_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.userAddress.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="pincode_areas">
            @includeIf('admin.pincodes.relationships.pincodeAreas', ['areas' => $pincode->pincodeAreas])
        </div>
        <div class="tab-pane" role="tabpanel" id="pincode_user_addresses">
            @includeIf('admin.pincodes.relationships.pincodeUserAddresses', ['userAddresses' => $pincode->pincodeUserAddresses])
        </div>
    </div>
</div>

@endsection