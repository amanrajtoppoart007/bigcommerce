@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.follower.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.followers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.follower.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.follower.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="follow_id">{{ trans('cruds.follower.fields.follow') }}</label>
                <select class="form-control select2 {{ $errors->has('follow') ? 'is-invalid' : '' }}" name="follow_id" id="follow_id" required>
                    @foreach($follows as $id => $follow)
                        <option value="{{ $id }}" {{ old('follow_id') == $id ? 'selected' : '' }}>{{ $follow }}</option>
                    @endforeach
                </select>
                @if($errors->has('follow'))
                    <div class="invalid-feedback">
                        {{ $errors->first('follow') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.follower.fields.follow_helper') }}</span>
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