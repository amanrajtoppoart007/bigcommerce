@extends("guest.layout.app")
@section("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
@endsection
@section("content")
    <!-- Main (Start) -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light" id="registration-form-section">
            <br>
            <div class="container">

                <!-- Back Buttton -->
{{--                <a href="{{ route('register') }}" class="btn btn-theme-1 btn-sm rounded shadow"><img--}}
{{--                        src="{{ asset('assets/assets/icons/back.svg') }}" class="img-fluid btn-icon ml-0 mr-1">Back to--}}
{{--                    Dashboard</a>--}}
{{--                <br>--}}
{{--                <br>--}}

                <!-- Registration Form Card (Start) -->
                <div class="card border-0 shadow">

                    <form class="form-group" id="help_center_registration_form" method="POST"
                          action="{{ route("store.helpCenter.register") }}"
                          enctype="multipart/form-data">

                        <!-- Card Header -->
                        <div class="card-header bg-white" align="center">
                            <h4 class="font-weight-bolder text-theme-1 mt-2">{{ trans('global.fill_the_registration_details') }}</h4>
                        </div>

                        <!-- Card Body (Start) -->
                        <div class="card-body">

                            <!-- Help Center Details (Start) -->
                            <h5 class="font-weight-bold text-theme-1">{{ trans('global.kv_pro_help_center_user_details') }}</h5>
                            <div class="card">
                                <div class="card-body pt-0">
                                    <div class="row">

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="name">{{ trans('cruds.helpCenter.fields.name') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="text" name="name" id="name"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="email">{{ trans('cruds.helpCenter.fields.email') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="email" name="email" id="email"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="mobile">{{ trans('cruds.helpCenter.fields.mobile') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="number" name="mobile" id="mobile"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="secondary_contact">{{ trans('cruds.helpCenterProfile.fields.secondary_contact') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="number" name="secondary_contact" id="secondary_contact"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="password">{{ trans('cruds.helpCenter.fields.password') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="password" name="password" id="password" maxlength="6"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="role">{{ trans('cruds.helpCenter.fields.role') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <select class="custom-select w-100" name="role" id="role" required>
                                                    <option value="" selected disabled>Select Role</option>
                                                    @foreach(App\Models\HelpCenter::ROLE_SELECT as $key => $label)
                                                        <option
                                                            value="{{ $key }}" {{ old('role', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- Help Center Details (End) -->

                            <hr>

                            <!-- Business Details (Start) -->
                            <h5 class="font-weight-bold text-theme-1">{{ trans('global.enter_your_business_details') }}</h5>
                            <div class="row mt-3">

                                <!-- Orginazation Detail (Start) -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-theme-1 font-weight-bolder" align="center">{{ trans('global.organisation_details') }}</h6>
                                            <hr class="w-50 mx-auto">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_name">{{ trans('cruds.helpCenterProfile.fields.organization_name') }}</label>
                                                <input type="text" name="organization_name" id="organization_name"
                                                       class="input-group-text bg-transparent w-100 text-left">
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_address">{{ trans('cruds.helpCenterProfile.fields.organization_address') }}</label>
                                                <input type="text" name="organization_address" id="organization_address"
                                                       class="input-group-text bg-transparent w-100 text-left">
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_street">{{ trans('cruds.helpCenterProfile.fields.organization_street') }}</label>
                                                <input type="text" name="organization_street" id="organization_street"
                                                       class="input-group-text bg-transparent w-100 text-left">
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_state_id">{{ trans('cruds.helpCenterProfile.fields.organization_state') }}</label>
                                                <select class="custom-select w-100" name="organization_state_id"
                                                        id="organization_state_id">
                                                    <option value="" selected disabled>Select State</option>
                                                    @foreach($organization_states as $id => $organization_state)
                                                        <option
                                                            value="{{ $id }}" {{ old('organization_state_id') == $id ? 'selected' : '' }}>{{ $organization_state }}</option>
                                                    @endforeach
                                                    <div class="invalid-feedback"></div>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_district_id">{{ trans('cruds.helpCenterProfile.fields.organization_district') }}</label>
                                                <select class="custom-select w-100" name="organization_district_id"
                                                        id="organization_district_id">
                                                    <option value="" selected disabled>Select District</option>
                                                    @foreach($organization_districts as $id => $organization_district)
                                                        <option
                                                            value="{{ $id }}" {{ old('organization_district_id') == $id ? 'selected' : '' }}>{{ $organization_district }}</option>
                                                    @endforeach
                                                    <div class="invalid-feedback"></div>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_city_id">{{ trans('cruds.helpCenterProfile.fields.organization_city') }}</label>
                                                <select class="custom-select w-100" name="organization_city_id"
                                                        id="organization_city_id">
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach($organization_cities as $id => $organization_city)
                                                        <option
                                                            value="{{ $id }}" {{ old('organization_city_id') == $id ? 'selected' : '' }}>{{ $organization_city }}</option>
                                                    @endforeach
                                                    <div class="invalid-feedback"></div>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="organization_pincode_id">{{ trans('cruds.helpCenterProfile.fields.organization_pincode') }}</label>
                                                <select class="custom-select w-100" name="organization_pincode_id"
                                                        id="organization_pincode_id">
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach($representativePincodes as $id => $representativePincode)
                                                        <option
                                                            value="{{ $id }}" {{ old('organization_pincode_id') == $id ? 'selected' : '' }}>{{ $representativePincode }}</option>
                                                    @endforeach
                                                    <div class="invalid-feedback"></div>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Orginazation Detail (End) -->

                                <!-- Representative Detail (Start) -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="text-theme-1 font-weight-bolder" align="center">{{ trans('global.representative_details') }}</h6>
                                            <hr class="w-50 mx-auto">
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_name">{{ trans('cruds.helpCenterProfile.fields.representative_name') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="text" name="representative_name" id="representative_name"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_designation">{{ trans('cruds.helpCenterProfile.fields.representative_designation') }}</label>
                                                <input type="text" name="representative_designation"
                                                       id="representative_designation"
                                                       class="input-group-text bg-transparent w-100 text-left">
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_address">{{ trans('cruds.helpCenterProfile.fields.representative_address') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="text" name="representative_address"
                                                       id="representative_address"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_street">{{ trans('cruds.helpCenterProfile.fields.representative_street') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <input type="text" name="representative_street"
                                                       id="representative_street"
                                                       class="input-group-text bg-transparent w-100 text-left" required>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_state_id">{{ trans('cruds.helpCenterProfile.fields.representative_state') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <select class="custom-select w-100" name="representative_state_id"
                                                        id="representative_state_id" required>
                                                    <option value="" selected disabled>Select State</option>
                                                    @foreach($representative_states as $id => $representative_state)
                                                        <option
                                                            value="{{ $id }}" {{ old('representative_state_id') == $id ? 'selected' : '' }}>{{ $representative_state }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_district_id">{{ trans('cruds.helpCenterProfile.fields.representative_district') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <select class="custom-select w-100" name="representative_district_id"
                                                        id="representative_district_id" required>
                                                    <option value="" selected disabled>Select District</option>
                                                    @foreach($representative_districts as $id => $representative_district)
                                                        <option
                                                            value="{{ $id }}" {{ old('representative_district_id') == $id ? 'selected' : '' }}>{{ $representative_district }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_city_id">{{ trans('cruds.helpCenterProfile.fields.representative_city') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <select class="custom-select w-100" name="representative_city_id"
                                                        id="representative_city_id" required>
                                                    <option value="" selected disabled>Select City</option>
                                                    <option value="1">District</option>
                                                </select>
                                                <div class="invalid-feedback"></div>

                                            </div>
                                            <div class="mt-3">
                                                <label class="font-weight-bolder text-dark"
                                                       for="representative_pincode_id">{{ trans('cruds.helpCenterProfile.fields.representative_pincode') }}</label><label
                                                    class="text-danger ml-2 font-weight-bolder">*</label>
                                                <select class="custom-select w-100" name="representative_pincode_id"
                                                        id="representative_pincode_id" required>
                                                    <option value="" selected disabled>Select Pincode</option>
                                                    @foreach($representativePincodes as $id => $representativePincode)
                                                        <option
                                                            value="{{ $id }}" {{ old('representative_pincode_id') == $id ? 'selected' : '' }}>{{ $representativePincode }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Representative Detail (End) -->
                            </div>
                            <br>
                            <!-- Business Details (End) -->

                            <hr>

                        </div>
                        <!-- Card Body (End) -->

                        <!-- Card Footer -->
                        <div class="card-footer bg-white" align="center">
                            <div class="form-check-inline">
                                <input type="checkbox" name="terms" class="custom-checkbox mt-n3 mr-2" required>
                                <p class="description-1">By Registering with us,you agree with our <a href="#"
                                                                                                      class="card-link">terms
                                        & conditions </a>and <a href="#" class="card-link">privacy policy</a></p>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-theme-1 rounded px-4">Submit<img
                                    src="{{asset('assets/assets/icons/circle-arrow.svg')}}" alt="submit" class="btn-icon"></button>
                        </div>

                    </form>
                </div>
                <!-- Registration Form Card (End) -->

            </div>
            <br>
        </section>
        <!-- Section First (End) -->

    </main>
    <!-- Main (End) -->
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $("#help_center_registration_form").on("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(document.getElementById('help_center_registration_form'));

                $.ajax({
                    url: "{{route('store.helpCenter.register')}}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $("#overlay").show();
                    },
                    success: function (res) {
                        if (res.response === "success") {
                            // $.notify(res.message, 'white');
                            toastr.success(res.message, '', {
                                progressBar: true,
                                timeOut: 2000,
                                positionClass: 'toast-top-left'
                            });
                            $("#help_center_registration_form")[0].reset();
                            window.open(res.url, '_self');
                        } else {
                            // $.notify(res.message, 'white');
                            toastr.error(res.message, '', {
                                progressBar: true,
                                timeOut: 2000,
                                positionClass: 'toast-top-left'
                            });
                        }
                    },
                    error: function (jqXhr, json, errorThrown) {

                        let data = jqXhr.responseJSON;

                        if (data.errors) {
                            $.each(data.errors, function (index, item) {
                                $(`#${index}`).addClass("is-invalid").tooltip({title: item[0]});
                                $(`#${index}`).next('.invalid-feedback').text(item[0]);
                                // $.notify(item[0], 'white');
                                toastr.error(item[0], '', {
                                    progressBar: true,
                                    timeOut: 2000,
                                    positionClass: 'toast-top-left'
                                });
                            })
                        }
                        if (data.message) {
                            // $.notify(data.message, 'white');
                            toastr.error(data.message, '', {
                                progressBar: true,
                                timeOut: 2000,
                                positionClass: 'toast-top-left'
                            });
                        }
                    },

                    complete: function () {
                        $("#overlay").hide();
                    }
                });
            });
        });
    </script>
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
                            // $("#organization_district_id").select2();
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
                            // $("#representative_district_id").select2();
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

                            // $("#organization_city_id").select2();
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

                            // $("#representative_city_id").select2();
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

                            // $("#representative_pincode_id").select2();
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

                            // $("#organization_pincode_id").select2();
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

