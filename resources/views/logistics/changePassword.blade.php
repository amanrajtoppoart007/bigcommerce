@extends('logistics.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            Change Password
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('logistics.change.password') }}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="old_password">Old Password</label>
                            <input class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" type="password" name="old_password" id="old_password" value="{{ old('old_password') }}" required>
                            @if($errors->has('old_password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('old_password') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="password">New Password</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" value="{{ old('password') }}" required>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="confirm_password">Confirm New Password</label>
                            <input class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}" required>
                            @if($errors->has('confirm_password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('confirm_password') }}
                                </div>
                            @endif
                        </div>
                    </div>
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
