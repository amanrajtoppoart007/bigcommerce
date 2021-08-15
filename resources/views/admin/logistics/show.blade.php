@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.logistic.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.logistics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.id') }}
                        </th>
                        <td>
                            {{ $logistic->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.name') }}
                        </th>
                        <td>
                            {{ $logistic->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.email') }}
                        </th>
                        <td>
                            {{ $logistic->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.mobile') }}
                        </th>
                        <td>
                            {{ $logistic->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $logistic->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.logistic.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $logistic->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.logistics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
