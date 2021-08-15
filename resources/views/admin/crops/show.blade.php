@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crop.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crops.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crop.fields.id') }}
                        </th>
                        <td>
                            {{ $crop->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crop.fields.name') }}
                        </th>
                        <td>
                            {{ $crop->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crop.fields.category') }}
                        </th>
                        <td>
                            {{ App\Models\Crop::CATEGORY_SELECT[$crop->category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crop.fields.session') }}
                        </th>
                        <td>
                            {{ App\Models\Crop::SESSION_SELECT[$crop->session] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crop.fields.image') }}
                        </th>
                        <td>
                            @if($crop->image)
                                <a href="{{ $crop->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $crop->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crops.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection