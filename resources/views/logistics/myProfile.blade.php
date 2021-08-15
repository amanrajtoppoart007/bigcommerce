@extends('logistics.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.update') }} {{ trans('global.profile') }}
            <a href="{{ route('logistics.show.upload.documents.form') }}" class="pull-right">{{ trans('cruds.uploadDocuments.title') }}</a>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('logistics.update.profile') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.franchisee.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $franchisee->name ?? '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchisee.fields.name_helper') }}</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.franchisee.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $franchisee->email ?? '') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchisee.fields.email_helper') }}</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="mobile">{{ trans('cruds.franchisee.fields.mobile') }}</label>
                            <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $franchisee->mobile ?? '') }}" required>
                            @if($errors->has('mobile'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mobile') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchisee.fields.mobile_helper') }}</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="secondary_contact">{{ trans('cruds.franchiseeProfile.fields.secondary_contact') }}</label>
                            <input class="form-control {{ $errors->has('secondary_contact') ? 'is-invalid' : '' }}" type="text" name="secondary_contact" id="secondary_contact" value="{{ old('secondary_contact', $profile->secondary_contact) }}" required>
                            @if($errors->has('secondary_contact'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('secondary_contact') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.franchisee.fields.role') }}</label>
                            <select class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" id="role">
                                <option value disabled {{ old('role', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Franchisee::ROLE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('role', $franchisee->role) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('role') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchisee.fields.role_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="gst_number">{{ trans('cruds.helpCenterProfile.fields.gst_number') }}</label>
                            <input class="form-control {{ $errors->has('gst_number') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="gst_number" id="gst_number" value="{{ $profile->gst_number ?? '' }}">
                            @if($errors->has('gst_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gst_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="work_area">{{ trans('cruds.helpCenterProfile.fields.work_area') }}</label>
                            <input class="form-control {{ $errors->has('work_area') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="work_area" id="work_area" value="{{ $profile->work_area ?? '' }}">
                            @if($errors->has('work_area'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('work_area') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label for="organization_name">{{ trans('cruds.franchiseeProfile.fields.organization_name') }}</label>
                            <input class="form-control {{ $errors->has('organization_name') ? 'is-invalid' : '' }}" type="text" name="organization_name" id="organization_name" value="{{ old('organization_name', $profile->organization_name) }}">
                            @if($errors->has('organization_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="organization_address">{{ trans('cruds.franchiseeProfile.fields.organization_address') }}</label>
                            <textarea class="form-control {{ $errors->has('organization_address') ? 'is-invalid' : '' }}" name="organization_address" id="organization_address">{{ old('organization_address', $profile->organization_address) }}</textarea>
                            @if($errors->has('organization_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="organization_address_line_two">{{ trans('cruds.franchiseeProfile.fields.organization_address_line_two') }}</label>
                            <input class="form-control {{ $errors->has('organization_address_line_two') ? 'is-invalid' : '' }}" type="text" name="organization_address_line_two" id="organization_address_line_two" value="{{ old('organization_address_line_two', $profile->organization_address_line_two) }}">
                            @if($errors->has('organization_address_line_two'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_address_line_two') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_address_line_two_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="organization_street">{{ trans('cruds.franchiseeProfile.fields.organization_street') }}</label>
                            <input class="form-control {{ $errors->has('organization_street') ? 'is-invalid' : '' }}" type="text" name="organization_street" id="organization_street" value="{{ old('organization_street', $profile->organization_street) }}">
                            @if($errors->has('organization_street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_street_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="organization_state_id">{{ trans('cruds.franchiseeProfile.fields.organization_state') }}</label>
                            <select class="form-control select2 {{ $errors->has('organization_state_id') ? 'is-invalid' : '' }}" name="organization_state_id" id="organization_state_id">
                                @foreach($states as $id => $state)
                                    <option value="{{ $id }}" {{ (old('organization_state_id') ? old('organization_state_id') : $profile->organization_state_id ?? '') == $id ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('organization_state_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_state_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="organization_district_id">{{ trans('cruds.franchiseeProfile.fields.organization_district') }}</label>
                            <select class="form-control select2 {{ $errors->has('organization_district_id') ? 'is-invalid' : '' }}" name="organization_district_id" id="organization_district_id">
                                @foreach($districts as $id => $district)
                                    <option value="{{ $id }}" {{ (old('organization_district_id') ? old('organization_district_id') : $profile->organization_district_id ?? '') == $id ? 'selected' : '' }}>{{ $district }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('organization_district_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_district_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="organization_city_id">{{ trans('cruds.franchiseeProfile.fields.organization_city') }}</label>
                            <select class="form-control select2 {{ $errors->has('organization_city_id') ? 'is-invalid' : '' }}" name="organization_city_id" id="organization_city_id">
                                @foreach($cities as $id => $city)
                                    <option value="{{ $id }}" {{ (old('organization_city_id') ? old('organization_city_id') : $profile->organization_city_id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('organization_city_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_city_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.organization_city_helper') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label
                                for="organization_pincode_id">{{ trans('cruds.helpCenterProfile.fields.organization_pincode') }}</label>
                            <select
                                class="form-control select2 {{ $errors->has('organization_pincode_id') ? 'is-invalid' : '' }}"
                                name="organization_pincode_id" id="organization_pincode_id">
                                @foreach($pincodes as $id => $pincode)
                                    <option
                                        value="{{ $id }}" {{ old('organization_pincode_id', $profile->organization_pincode_id) == $id ? 'selected' : '' }}>{{ $pincode }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('organization_pincode_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('organization_pincode_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="representative_name">{{ trans('cruds.franchiseeProfile.fields.representative_name') }}</label>
                            <input class="form-control {{ $errors->has('representative_name') ? 'is-invalid' : '' }}" type="text" name="representative_name" id="representative_name" value="{{ old('representative_name', $profile->representative_name) }}" required>
                            @if($errors->has('representative_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="representative_designation">{{ trans('cruds.franchiseeProfile.fields.representative_designation') }}</label>
                            <input class="form-control {{ $errors->has('representative_designation') ? 'is-invalid' : '' }}" type="text" name="representative_designation" id="representative_designation" value="{{ old('representative_designation', $profile->representative_designation) }}">
                            @if($errors->has('representative_designation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_designation') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_designation_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="representative_address">{{ trans('cruds.franchiseeProfile.fields.representative_address') }}</label>
                            <textarea class="form-control {{ $errors->has('representative_address') ? 'is-invalid' : '' }}" name="representative_address" id="representative_address" required>{{ old('representative_address', $profile->representative_address) }}</textarea>
                            @if($errors->has('representative_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="representative_address_line_two">{{ trans('cruds.franchiseeProfile.fields.representative_address_line_two') }}</label>
                            <input class="form-control {{ $errors->has('representative_address_line_two') ? 'is-invalid' : '' }}" type="text" name="representative_address_line_two" id="representative_address_line_two" value="{{ old('representative_address_line_two', $profile->representative_address_line_two) }}">
                        @if($errors->has('representative_address_line_two'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_address_line_two') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_address_line_two_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="representative_street">{{ trans('cruds.franchiseeProfile.fields.representative_street') }}</label>
                            <input class="form-control {{ $errors->has('representative_street') ? 'is-invalid' : '' }}" type="text" name="representative_street" id="representative_street" value="{{ old('representative_street', $profile->representative_street) }}" required>
                            @if($errors->has('representative_street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_street_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="representative_state_id">{{ trans('cruds.franchiseeProfile.fields.representative_state') }}</label>
                            <select class="form-control select2 {{ $errors->has('representative_state_id') ? 'is-invalid' : '' }}" name="representative_state_id" id="representative_state_id">
                                @foreach($states as $id => $state)
                                    <option value="{{ $id }}" {{ (old('representative_state_id') ? old('representative_state_id') : $profile->representative_state_id ?? '') == $id ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('representative_state_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_state_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="representative_district_id">{{ trans('cruds.franchiseeProfile.fields.representative_district') }}</label>
                            <select class="form-control select2 {{ $errors->has('representative_district_id') ? 'is-invalid' : '' }}" name="representative_district_id" id="representative_district_id">
                                @foreach($districts as $id => $district)
                                    <option value="{{ $id }}" {{ (old('representative_district_id') ? old('representative_district_id') : $profile->representative_district_id ?? '') == $id ? 'selected' : '' }}>{{ $district }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('representative_district_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_district_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_district_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="representative_city_id">{{ trans('cruds.franchiseeProfile.fields.representative_city') }}</label>
                            <select class="form-control select2 {{ $errors->has('representative_city') ? 'is-invalid' : '' }}" name="representative_city_id" id="representative_city_id">
                                @foreach($cities as $id => $city)
                                    <option value="{{ $id }}" {{ (old('representative_city_id') ? old('representative_city_id') : $profile->representative_city_id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('representative_city_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('representative_city_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.franchiseeProfile.fields.representative_city_helper') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="required"
                                   for="representative_pincode_id">{{ trans('cruds.helpCenterProfile.fields.representative_pincode') }}</label>
                            <select
                                class="form-control select2 {{ $errors->has('representative_pincode_id') ? 'is-invalid' : '' }}"
                                name="representative_pincode_id" id="representative_pincode_id" required>
                                @foreach($pincodes as $id => $pincode)
                                    <option
                                        value="{{ $id }}" {{ old('representative_pincode_id', $profile->representative_pincode_id) == $id ? 'selected' : '' }}>{{ $pincode }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @if($errors->has('representative_pincode_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('representative_pincode_id') }}
                                    </div>
                                @endif
                            </div>
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
            $("#organization_state_id").on("change", function () {

                $("#organization_district_id").empty();
                $.ajax({
                    url: "{{route('ajax.district.list')}}",
                    type: 'POST',
                    data: {'state_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select District</option>`));
                            $("#organization_district_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#organization_district_id").append($option);
                            });
                            $("#organization_district_id").select2();
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });


            $("#representative_state_id").on("change", function () {

                $("#representative_district_id").empty();
                $.ajax({
                    url: "{{route('ajax.district.list')}}",
                    type: 'POST',
                    data: {'state_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select District</option>`));
                            $("#representative_district_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#representative_district_id").append($option);
                            });
                            $("#representative_district_id").select2();
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#organization_district_id").on("change", function () {

                let $_option = `<option value="1">Demo Block</option>`;

                $("#organization_city_id").empty();
                $.ajax({
                    url: "{{route('ajax.block.list')}}",
                    type: 'POST',
                    data: {'district_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select City</option>`));
                            $("#organization_city_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#organization_city_id").append($option);
                            });

                            $("#organization_city_id").select2();
                        } else {
                            $("#organization_city_id").append($_option);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });


            $("#representative_district_id").on("change", function () {

                let $_option = `<option value="1">Demo Block</option>`;

                $("#representative_city_id").empty();
                $.ajax({
                    url: "{{route('ajax.block.list')}}",
                    type: 'POST',
                    data: {'district_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Block</option>`));
                            $("#representative_city_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#representative_city_id").append($option);
                            });

                            $("#representative_city_id").select2();
                        } else {
                            $("#representative_city_id").append($_option);
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#representative_city_id").on("change", function () {

                let $_option = `<option value="1">Demo Pincode</option>`;

                $("#representative_pincode_id").empty();
                $.ajax({
                    url: "{{route('ajax.pincode.list')}}",
                    type: 'POST',
                    data: {'block_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Pincode</option>`));
                            $("#representative_pincode_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.pincode}</option>`));
                                $("#representative_pincode_id").append($option);
                            });

                            $("#representative_pincode_id").select2();
                        } else {
                            $("#representative_pincode_id").append($_option);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#organization_city_id").on("change", function () {

                let $_option = `<option value="1">Demo Pincode</option>`;

                $("#organization_pincode_id").empty();
                $.ajax({
                    url: "{{route('ajax.pincode.list')}}",
                    type: 'POST',
                    data: {'block_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select Pincode</option>`));
                            $("#organization_pincode_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.pincode}</option>`));
                                $("#organization_pincode_id").append($option);
                            });

                            $("#organization_pincode_id").select2();
                        } else {
                            $("#organization_pincode_id").append($_option);
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
