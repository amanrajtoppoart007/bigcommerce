@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.userAddress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-addresses.update", [$userAddress->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.userAddress.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $userAddress->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pincode_id">{{ trans('cruds.userAddress.fields.pincode') }}</label>
                <select class="form-control select2 {{ $errors->has('pincode') ? 'is-invalid' : '' }}" name="pincode_id" id="pincode_id" required>
                    @foreach($pincodes as $id => $pincode)
                        <option value="{{ $id }}" {{ (old('pincode_id') ? old('pincode_id') : $userAddress->pincode->id ?? '') == $id ? 'selected' : '' }}>{{ $pincode }}</option>
                    @endforeach
                </select>
                @if($errors->has('pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pincode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="district_id">{{ trans('cruds.userAddress.fields.district') }}</label>
                <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}" name="district_id" id="district_id" required>
                    @foreach($districts as $id => $district)
                        <option value="{{ $id }}" {{ (old('district_id') ? old('district_id') : $userAddress->district->id ?? '') == $id ? 'selected' : '' }}>{{ $district }}</option>
                    @endforeach
                </select>
                @if($errors->has('district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="block_id">{{ trans('cruds.userAddress.fields.block') }}</label>
                <select class="form-control select2 {{ $errors->has('block') ? 'is-invalid' : '' }}" name="block_id" id="block_id" required>
                    @foreach($blocks as $id => $block)
                        <option value="{{ $id }}" {{ (old('block_id') ? old('block_id') : $userAddress->block->id ?? '') == $id ? 'selected' : '' }}>{{ $block }}</option>
                    @endforeach
                </select>
                @if($errors->has('block'))
                    <div class="invalid-feedback">
                        {{ $errors->first('block') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.block_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="state_id">{{ trans('cruds.userAddress.fields.state') }}</label>
                <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state_id" id="state_id" required>
                    @foreach($states as $id => $state)
                        <option value="{{ $id }}" {{ (old('state_id') ? old('state_id') : $userAddress->state->id ?? '') == $id ? 'selected' : '' }}>{{ $state }}</option>
                    @endforeach
                </select>
                @if($errors->has('state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="area_id">{{ trans('cruds.userAddress.fields.area') }}</label>
                <select class="form-control select2 {{ $errors->has('area') ? 'is-invalid' : '' }}" name="area_id" id="area_id" required>
                    @foreach($areas as $id => $area)
                        <option value="{{ $id }}" {{ (old('area_id') ? old('area_id') : $userAddress->area->id ?? '') == $id ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
                @if($errors->has('area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.userAddress.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address', $userAddress->address) }}</textarea>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.userAddress.fields.address_type') }}</label>
                @foreach(App\Models\UserAddress::ADDRESS_TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('address_type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="address_type_{{ $key }}" name="address_type" value="{{ $key }}" {{ old('address_type', $userAddress->address_type) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="address_type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('address_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.address_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="street">{{ trans('cruds.userAddress.fields.street') }}</label>
                <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $userAddress->street) }}">
                @if($errors->has('street'))
                    <div class="invalid-feedback">
                        {{ $errors->first('street') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.street_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address_line_two">{{ trans('cruds.userAddress.fields.address_line_two') }}</label>
                <input class="form-control {{ $errors->has('address_line_two') ? 'is-invalid' : '' }}" type="text" name="address_line_two" id="address_line_two" value="{{ old('address_line_two', $userAddress->address_line_two) }}">
                @if($errors->has('address_line_two'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address_line_two') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userAddress.fields.address_line_two_helper') }}</span>
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