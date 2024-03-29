@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.area.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.areas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.area.fields.id') }}
                        </th>
                        <td>
                            {{ $area->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.area.fields.area') }}
                        </th>
                        <td>
                            {{ $area->area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.area.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $area->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.area.fields.pincode') }}
                        </th>
                        <td>
                            {{ $area->pincode->pincode ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.areas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection