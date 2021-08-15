@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.membershipPlan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.membership-plans.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="required" for="plan_type">{{ trans('cruds.membershipPlan.fields.plan_type') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="plan_type" id="plan_type" value="{{ old('plan_type', '') }}" required>
                        @if($errors->has('plan_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('plan_type') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.membershipPlan.fields.plan_type_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="required" for="fees">{{ trans('cruds.membershipPlan.fields.fees') }}</label>
                        <input class="form-control {{ $errors->has('fees') ? 'is-invalid' : '' }}" type="number" name="fees" id="fees" value="{{ old('fees') }}" required>
                        @if($errors->has('fees'))
                            <div class="invalid-feedback">
                                {{ $errors->first('fees') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.membershipPlan.fields.fees_helper') }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.membershipPlan.fields.member_type') }}</label>
                        <select class="form-control {{ $errors->has('member_type') ? 'is-invalid' : '' }}" name="member_type" id="member_type" required>
                            <option value disabled {{ old('member_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\MembershipPlan::MEMBER_TYPES_RADIO as $key => $label)
                                <option value="{{ $key }}" {{ old('member_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('member_type'))
                            <div class="invalid-feedback">
                                {{ $errors->first('member_type') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.membershipPlan.fields.member_type_helper') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.membershipPlan.fields.status') }}</label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                            <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\MembershipPlan::STATUS_RADIO as $key => $label)
                                <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.membershipPlan.fields.status_helper') }}</span>
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
