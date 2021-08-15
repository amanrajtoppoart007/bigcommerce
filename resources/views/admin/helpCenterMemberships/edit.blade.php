@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.membership.title_singular') }}
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('admin.help-center-memberships.update', $membership) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label class="required"
                                   for="member_id">{{ trans('cruds.membership.fields.member') }}</label>
                            <select class="form-control select2 {{ $errors->has('help_center') ? 'is-invalid' : '' }}"
                                    name="member_id" id="member_id" disabled>
                                @foreach($helpCenters as $id => $helpCenter)
                                    <option
                                        value="{{ $id }}" {{ old('member_id', $membership->member_id ?? '') == $id ? 'selected' : '' }}>{{ $helpCenter }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('member_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('member_id') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.member_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required"
                                for="plan_type">{{ trans('cruds.membership.fields.plan_type') }}</label>
                            <select class="form-control select2" name="plan_type" id="plan_type" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach($membershipPlans as $plan)
                                    <option
                                        value="{{ $plan->id }}" {{ old('plan_type', $membership->plan_type ?? '') == $plan->plan_type ? 'selected' : '' }}>{{ $plan->plan_type }}
                                        - {{ $plan->fees }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('plan_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('plan_type') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.plan_type_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required"
                                for="payment_method">{{ trans('cruds.membership.fields.payment_method') }}</label>
                            <select class="form-control select2" name="payment_method" id="payment_method" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\HelpCenterProfile::PAYMENT_METHOD_RADIO as $key => $label)
                                    <option
                                        value="{{ $key }}" {{ old('payment_method', $membership->payment_method ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('payment_method'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_method') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.payment_method_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required"
                                for="membership_status">{{ trans('cruds.membership.fields.membership_status') }}</label>
                            <select class="form-control select2" name="membership_status" id="membership_status" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Membership::MEMBERSHIP_STATUS_RADIO as $key => $label)
                                    <option
                                        value="{{ $key }}" {{ old('membership_status', $membership->membership_status ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('membership_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('membership_status') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.membership_status_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required"
                                for="start_date">{{ trans('cruds.membership.fields.start_date') }}</label>
                            <input class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                                   type="date" name="start_date" id="start_date"
                                   value="{{ old('start_date', $membership->start_date ?? '') }}" required>
                            @if($errors->has('start_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.start_date_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label
                                class="required"
                                for="expiry_date">{{ trans('cruds.membership.fields.expiry_date') }}</label>
                            <input class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}"
                                   type="date" name="expiry_date" id="expiry_date"
                                   value="{{ old('expiry_date', $membership->expiry_date ?? '') }}" required>
                            @if($errors->has('expiry_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expiry_date') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.membership.fields.expiry_date_helper') }}</span>
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
