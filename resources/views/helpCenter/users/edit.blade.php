@extends('helpCenter.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create_farmer_header') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("helpCenter.users.update", [$user->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name" id="name" value="{{ old('name', $user->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="mobile">{{ trans('cruds.user.fields.mobile') }}</label>
                            <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text"
                                   name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                            @if($errors->has('mobile'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mobile') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.mobile_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="secondary_mobile">{{ trans('cruds.user.fields.secondary_mobile') }}</label>
                            <input class="form-control {{ $errors->has('secondary_mobile') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="secondary_mobile" id="secondary_mobile"
                                   value="{{ old('secondary_mobile', $userProfile->secondary_mobile ?? '') }}" required>
                            @if($errors->has('secondary_mobile'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('secondary_mobile') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.user.fields.secondary_mobile_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                   name="email" id="email" value="{{ old('email', $user->email) }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   type="password"
                                   name="password" id="password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="approved" value="0">
                                <input class="form-check-input" type="checkbox" name="approved" id="approved"
                                       value="1" {{ $user->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                       for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                            </div>
                            @if($errors->has('approved'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('approved') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="crops">{{ trans('cruds.userProfile.fields.crops') }}</label>
                            <select class="form-control {{ $errors->has('crops') ? 'is-invalid' : '' }} select2"
                                    name="crops[]" id="crops" multiple="multiple" required>
                                <option value="">Select Crop</option>
                                @foreach($crops as $crop_id => $crop_name)
                                    @php $selected = "" @endphp
                                    @if((!empty($userProfile->crops)) && is_array($userProfile->crops) && $crop_id)
                                        @if(in_array($crop_id, $userProfile->crops))
                                            @php $selected = "selected" @endphp
                                        @endif
                                    @endif
                                    <option value="{{$crop_id}}" {{$selected}}>{{$crop_name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('crops'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('crops') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label
                                class="required"
                                for="agricultural_land">{{ trans('cruds.userProfile.fields.agricultural_land') }}</label>
                            <input class="form-control {{ $errors->has('agricultural_land') ? 'is-invalid' : '' }}"
                                   type="number" name="agricultural_land" id="agricultural_land"
                                   value="{{ old('farming_land_area', $userProfile->agricultural_land ?? '') }}" step="0.01" required>
                            @if($errors->has('agricultural_land'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agricultural_land') }}
                                </div>
                            @endif
                            <span class="help-block">{{trans('cruds.userProfile.fields.agricultural_land_helper')}}</span>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">


                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.userAddress.fields.address') }}</label>
                            <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                      name="address"
                                      id="address" required>{{ old('address', $userAddress->address) }}</textarea>
                            @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.address_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="street">{{ trans('cruds.userAddress.fields.street') }}</label>
                            <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text"
                                   name="street" id="street" value="{{ old('street', $userAddress->street) }}">
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.street_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="state_id">{{ trans('cruds.userAddress.fields.state') }}</label>
                            <select class="form-control select2 {{ $errors->has('state_id') ? 'is-invalid' : '' }}"
                                    name="state_id" id="state_id" required>
                                @foreach($states as $id => $state)
                                    <option
                                        value="{{ $id }}" {{ (old('state_id') ? old('state_id') : $userAddress->state->id ?? '') == $id ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('state_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.state_helper') }}</span>
                        </div>


                        <div class="form-group">
                            <label class="required"
                                   for="district_id">{{ trans('cruds.userAddress.fields.district') }}</label>
                            <select class="form-control select2 {{ $errors->has('district_id') ? 'is-invalid' : '' }}"
                                    name="district_id" id="district_id" required>
                                @foreach($districts as $id => $district)
                                    <option
                                        value="{{ $id }}" {{ (old('district_id') ? old('district_id') : $userAddress->district->id ?? '') == $id ? 'selected' : '' }}>{{ $district }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('district_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('district_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.district_helper') }}</span>
                        </div>


                        <div class="form-group">
                            <label class="required" for="block_id">{{ trans('cruds.userAddress.fields.block') }}</label>
                            <select class="form-control select2 {{ $errors->has('block_id') ? 'is-invalid' : '' }}"
                                    name="block_id" id="block_id" required>
                                @foreach($blocks as $id => $block)
                                    <option
                                        value="{{ $id }}" {{ (old('block_id') ? old('block_id') : $userAddress->block->id ?? '') == $id ? 'selected' : '' }}>{{ $block }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('block_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('block_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.block_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="pincode_id">{{ trans('cruds.userAddress.fields.pincode') }}</label>
                            <select class="form-control select2 {{ $errors->has('pincode_id') ? 'is-invalid' : '' }}"
                                    name="pincode_id" id="pincode_id" required>
                                @foreach($pincodes as $id => $pincode)
                                    <option
                                        value="{{ $id }}" {{ (old('pincode_id') ? old('pincode_id') : $userAddress->addressPincode->id ?? '') == $id ? 'selected' : '' }}>{{ $pincode }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('pincode_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pincode_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.pincode_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="area_id">{{ trans('cruds.userAddress.fields.area') }}</label>
                            <select class="form-control select2 {{ $errors->has('area_id') ? 'is-invalid' : '' }}"
                                    name="area_id" id="area_id" required>
                                @foreach($areas as $id => $area)
                                    <option
                                        value="{{ $id }}" {{ (old('area_id') ? old('area_id') : $userAddress->area->id ?? '') == $id ? 'selected' : '' }}>{{ $area }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('area_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('area_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.area_helper') }}</span>
                        </div>



                        <div class="form-group">
                            <label class="required"
                                   for="village">{{ trans('cruds.userAddress.fields.village') }}</label>

                            <input class="form-control {{ $errors->has('village') ? 'is-invalid' : '' }}" type="text"
                                   name="village" id="village" value="{{ old('village', $userAddress->village) }}" required>

                            @if($errors->has('village'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('village') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.village_helper') }}</span>
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

@section('scripts')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});

            $("#state_id").on("change", function () {

                $("#district_id").empty();
                $.ajax({
                    url: "{{route('ajax.district.list')}}",
                    type: 'POST',
                    data: {'state_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select District</option>`));
                            $("#district_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#district_id").append($option);
                            });
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#district_id").on("change", function () {

                $("#block_id").empty();
                $.ajax({
                    url: "{{route('ajax.block.list')}}",
                    type: 'POST',
                    data: {'district_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Block</option>`));
                            $("#block_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#block_id").append($option);
                            });
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#block_id").on("change", function () {

                $("#pincode_id").empty();
                $.ajax({
                    url: "{{route('ajax.pincode.list')}}",
                    type: 'POST',
                    data: {'block_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Pincode</option>`));
                            $("#pincode_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.pincode}</option>`));
                                $("#pincode_id").append($option);
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#pincode_id").on("change", function () {

                $("#area_id").empty();
                $.ajax({
                    url: "{{route('ajax.area.list')}}",
                    type: 'POST',
                    data: {'pincode_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Area</option>`));
                            $("#area_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.area}</option>`));
                                $("#area_id").append($option);
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });
        });
    </script>
@endsection
