@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create_farmer_header') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>


                        <div class="form-group">
                            <label class="required" for="mobile">{{ trans('cruds.user.fields.mobile') }}</label>
                            <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="number"
                                   maxlength="10"
                                   name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
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
                            <input type="number"
                                   class="form-control {{ $errors->has('secondary_mobile') ? 'is-invalid' : '' }}"
                                   name="secondary_mobile" id="secondary_mobile"
                                   value="{{ old('secondary_mobile', '') }}" maxlength="10" required>
                            @if($errors->has('secondary_mobile'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('secondary_mobile') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.secondary_mobile_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                   name="email" id="email" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   type="password"
                                   name="password" value="{{ old('password') }}" id="password" required>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="crops">{{ trans('cruds.userProfile.fields.crops') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all"
                                      style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control {{ $errors->has('crops') ? 'is-invalid' : '' }} select2"
                                    name="crops[]" id="crops" multiple="multiple" required>
                                @foreach($crops as $crop_id=>$crop_name)
                                    <option value="{{$crop_id}}">{{$crop_name}}</option>
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
                            <label class="required"
                                   for="mobile">{{trans('cruds.userProfile.fields.agricultural_land')}}</label>
                            <input type="number"
                                   class="form-control {{ $errors->has('agricultural_land') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="agricultural_land" id="agricultural_land"
                                   value="{{ old('agricultural_land', '') }}" required>
                            @if($errors->has('agricultural_land'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agricultural_land') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{trans('cruds.userProfile.fields.agricultural_land_helper')}}</span>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.userAddress.fields.address') }}</label>
                            <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                      name="address"
                                      id="address" required>{{ old('address') }}</textarea>
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
                                   name="street" id="street" value="{{ old('street', '') }}">
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.street_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required" for="state_id">{{ trans('cruds.userAddress.fields.state') }}</label>
                            <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                    name="state_id" id="state_id" required>
                                @foreach($states as $id => $state)
                                    <option
                                        value="{{ $id }}" {{ old('state_id') == $id ? 'selected' : '' }}>{{ $state }}</option>
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
                            <label class="required"
                                   for="district_id">{{ trans('cruds.userAddress.fields.district') }}</label>
                            <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}"
                                    name="district_id" id="district_id" required>
                                @foreach($districts as $id => $district)
                                    <option
                                        value="{{ $id }}" {{ old('district_id') == $id ? 'selected' : '' }}>{{ $district }}</option>
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
                            <select class="form-control select2 {{ $errors->has('block') ? 'is-invalid' : '' }}"
                                    name="block_id" id="block_id" required>
                                @foreach($blocks as $id => $block)
                                    <option
                                        value="{{ $id }}" {{ old('block_id') == $id ? 'selected' : '' }}>{{ $block }}</option>
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
                            <label class="required"
                                   for="pincode_id">{{ trans('cruds.userAddress.fields.pincode') }}</label>
                            <select class="form-control select2 {{ $errors->has('pincode_id') ? 'is-invalid' : '' }}"
                                    name="pincode_id" id="pincode_id" required>
                                @foreach($pincodes as $id=> $pincode)
                                    <option value="{{ $id }}" {{ old('pincode_id') == $id ? 'selected' : '' }}>{{ $pincode }}</option>
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
                            <label class="required" for="area_id">{{ trans('cruds.userAddress.fields.area') }}</label>
                            <select class="form-control select2 {{ $errors->has('area_id') ? 'is-invalid' : '' }}"
                                    name="area_id" id="area_id" required>
                                @foreach($areas as $id=> $area)
                                    <option value="{{ $id }}" {{ old('area_id') == $id ? 'selected' : '' }}>{{ $area }}</option>
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
                            <label class="required" for="village">
                                {{ trans('cruds.userAddress.fields.village') }}
                            </label>
                            <input type="text" class="form-control  {{ $errors->has('village') ? 'is-invalid' : '' }}"
                                   value="{{ old('village', '') }}" name="village" id="village" required>
                            @if($errors->has('village'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('village') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.village_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="help_center_id">{{ trans('cruds.user.fields.help_center') }}</label>
                            <select class="form-control select2 {{ $errors->has('help_center_id') ? 'is-invalid' : '' }}"
                                    name="help_center_id" id="help_center_id" required>
                                @foreach($helpCenters as $id=> $helpCenter)
                                    <option value="{{ $id }}" {{ old('help_center_id') == $id ? 'selected' : '' }}>{{ $helpCenter }}</option>
                                @endforeach

                            </select>
                            @if($errors->has('help_center_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('help_center_id') }}
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

