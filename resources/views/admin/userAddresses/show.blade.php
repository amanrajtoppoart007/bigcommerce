@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userAddress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.id') }}
                        </th>
                        <td>
                            {{ $userAddress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.user') }}
                        </th>
                        <td>
                            {{ $userAddress->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.pincode') }}
                        </th>
                        <td>
                            {{ $userAddress->pincode->pincode ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.district') }}
                        </th>
                        <td>
                            {{ $userAddress->district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.block') }}
                        </th>
                        <td>
                            {{ $userAddress->block->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.state') }}
                        </th>
                        <td>
                            {{ $userAddress->state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.area') }}
                        </th>
                        <td>
                            {{ $userAddress->area->area ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.address') }}
                        </th>
                        <td>
                            {{ $userAddress->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.address_type') }}
                        </th>
                        <td>
                            {{ App\Models\UserAddress::ADDRESS_TYPE_RADIO[$userAddress->address_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.street') }}
                        </th>
                        <td>
                            {{ $userAddress->street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.address_line_two') }}
                        </th>
                        <td>
                            {{ $userAddress->address_line_two }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-addresses.index') }}">
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
            <a class="nav-link" href="#address_orders" role="tab" data-toggle="tab">
                {{ trans('cruds.order.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="address_orders">
            @includeIf('admin.userAddresses.relationships.addressOrders', ['orders' => $userAddress->addressOrders])
        </div>
    </div>
</div>

@endsection