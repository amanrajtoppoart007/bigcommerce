@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userProfile.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.id') }}
                        </th>
                        <td>
                            {{ $userProfile->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.user') }}
                        </th>
                        <td>
                            {{ $userProfile->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.name') }}
                        </th>
                        <td>
                            {{ $userProfile->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.email') }}
                        </th>
                        <td>
                            {{ $userProfile->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.mobile') }}
                        </th>
                        <td>
                            {{ $userProfile->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.secondary_mobile') }}
                        </th>
                        <td>
                            {{ $userProfile->secondary_mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.farming_land_area') }}
                        </th>
                        <td>
                            {{ $userProfile->agricultural_land }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userProfile.fields.image') }}
                        </th>
                        <td>
                            @if($userProfile->image)
                                <a href="{{ $userProfile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $userProfile->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
