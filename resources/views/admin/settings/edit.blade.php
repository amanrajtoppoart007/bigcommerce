@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.update", [$setting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="setting_key">{{ trans('cruds.setting.fields.setting_key') }}</label>
                <input class="form-control {{ $errors->has('setting_key') ? 'is-invalid' : '' }}" type="text" name="setting_key" id="setting_key" value="{{ old('setting_key', $setting->setting_key) }}" required>
                @if($errors->has('setting_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('setting_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.setting_key_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="setting_value">{{ trans('cruds.setting.fields.setting_value') }}</label>
                <input class="form-control {{ $errors->has('setting_value') ? 'is-invalid' : '' }}" type="text" name="setting_value" id="setting_value" value="{{ old('setting_value', $setting->setting_value) }}" required>
                @if($errors->has('setting_value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('setting_value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.setting_value_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection