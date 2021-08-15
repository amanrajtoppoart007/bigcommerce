@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.franchisee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.franchisees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.id') }}
                        </th>
                        <td>
                            {{ $franchisee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.name') }}
                        </th>
                        <td>
                            {{ $franchisee->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.email') }}
                        </th>
                        <td>
                            {{ $franchisee->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.password') }}
                        </th>
                        <td>
                            ********
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.mobile') }}
                        </th>
                        <td>
                            {{ $franchisee->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $franchisee->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.mobile_verified_at') }}
                        </th>
                        <td>
                            {{ $franchisee->mobile_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.verification_token') }}
                        </th>
                        <td>
                            {{ $franchisee->verification_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.mobile_verification_token') }}
                        </th>
                        <td>
                            {{ $franchisee->mobile_verification_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.franchisee.fields.role') }}
                        </th>
                        <td>
                            {{ App\Models\Franchisee::ROLE_SELECT[$franchisee->role] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.franchisees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection