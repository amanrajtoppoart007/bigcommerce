@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.helpCenter.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.help-centers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.id') }}
                        </th>
                        <td>
                            {{ $helpCenter->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.name') }}
                        </th>
                        <td>
                            {{ $helpCenter->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.email') }}
                        </th>
                        <td>
                            {{ $helpCenter->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.mobile') }}
                        </th>
                        <td>
                            {{ $helpCenter->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.password') }}
                        </th>
                        <td>
                            ********
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.role') }}
                        </th>
                        <td>
                            {{ App\Models\HelpCenter::ROLE_SELECT[$helpCenter->role] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $helpCenter->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.mobile_verified_at') }}
                        </th>
                        <td>
                            {{ $helpCenter->mobile_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.verification_token') }}
                        </th>
                        <td>
                            {{ $helpCenter->verification_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.mobile_verification_token') }}
                        </th>
                        <td>
                            {{ $helpCenter->mobile_verification_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.helpCenter.fields.remember_token') }}
                        </th>
                        <td>
                            {{ $helpCenter->remember_token }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.help-centers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection