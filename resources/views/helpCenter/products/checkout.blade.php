@extends('helpCenter.layout.main')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('helpCenter.users.create') }}">
                {{ trans('global.add') }} {{ trans('global.farmer') }}
            </a>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input class="form-control" type="text" id="term"
                               placeholder="{{ trans('global.search_farmer') }}...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="data"></div>
                </div>
                <div class="col-12">
                    {{ trans('global.select_address') }}
                    <button class="btn btn-success pull-right" id="addButton">{{ trans('global.add_address') }}</button>
                    <hr>
                </div>
                <div class="col-12">
                    <div id="address-data"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label
                            class="required">{{ trans('cruds.helpCenterProfile.fields.payment_method') }}</label>
                        <div class="form-check {{ $errors->has('payment_method') ? 'is-invalid' : '' }}">
                            <input class="form-check-input payment-method" type="radio"
                                   id="payment_method_CASH"
                                   name="payment_method" value="CASH"
                                   {{ old('payment_method', '') === (string) 'CASH' ? 'checked' : '' }} required>
                            <label class="form-check-label"
                                   for="payment_method_CASH">CASH</label>
                        </div>
                        <div class="form-check {{ $errors->has('payment_method') ? 'is-invalid' : '' }}">
                            <input class="form-check-input payment-method" type="radio"
                                   id="payment_method_ONLINE"
                                   name="payment_method" value="ONLINE"
                                   {{ old('payment_method', '') === (string) 'ONLINE' ? 'checked' : '' }} required>
                            <label class="form-check-label"
                                   for="payment_method_ONLINE">ONLINE</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-danger"
                                id="place-order-button">{{ trans('global.place_order') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="addModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('cruds.userAddress.title_singular') }}</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form id="addressForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required"
                                           for="state_id">{{ trans('cruds.userAddress.fields.state') }}</label>
                                    <select class="form-control select2"
                                            name="state_id" id="state_id" required>
                                        @foreach($states as $id => $state)
                                            <option
                                                value="{{ $id }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required"
                                           for="district_id">{{ trans('cruds.userAddress.fields.district') }}</label>
                                    <select class="form-control select2"
                                            name="district_id" id="district_id" required>
                                        @foreach($districts as $id => $district)
                                            <option
                                                value="{{ $id }}">{{ $district }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required"
                                           for="block_id">{{ trans('cruds.userAddress.fields.block') }}</label>
                                    <select class="form-control select2"
                                            name="block_id" id="block_id" required>
                                        @foreach($blocks as $id => $block)
                                            <option
                                                value="{{ $id }}">{{ $block }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required"
                                           for="pincode_id">{{ trans('cruds.userAddress.fields.pincode') }}</label>
                                    <select class="form-control select2"
                                            name="pincode_id" id="pincode_id" required>
                                        @foreach($pincodes as $id => $pincode)
                                            <option
                                                value="{{ $id }}" {{ old('pincode_id') == $id ? 'selected' : '' }}>{{ $pincode }}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required"
                                           for="area_id">{{ trans('cruds.userAddress.fields.area') }}</label>
                                    <select class="form-control select2"
                                            name="area_id" id="area_id" required>
                                        @foreach($areas as $id => $area)
                                            <option
                                                value="{{ $id }}" {{ old('area_id') == $id ? 'selected' : '' }}>{{ $area }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="street">{{ trans('cruds.userAddress.fields.street') }}</label>
                                    <input class="form-control" type="text"
                                           name="street" id="street" value="{{ old('street', '') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.userAddress.fields.address') }}</label>
                            <textarea class="form-control"
                                      name="address" id="address" required>{{ old('address') }}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label
                                for="address_line_two">{{ trans('cruds.userAddress.fields.address_line_two') }}</label>
                            <input class="form-control"
                                   type="text" name="address_line_two" id="address_line_two"
                                   value="{{ old('address_line_two', '') }}">

                            <div class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('global.close') }}</button>
                        <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@section('scripts')
    <script>
        @parent
        $(function () {
            let selectedAddress = "";
            let selectedUser = "";

            $('#addButton').click(() => {
                if (selectedUser == "") {
                    alert('Please select a farmer.');
                } else {
                    $('#addModal').modal('show');
                }

            });

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                            $("#district_id").select2();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#district_id").on("change", function () {

                let $_option = `<option value="1">Demo Block</option>`;

                $("#block_id").empty();
                $.ajax({
                    url: "{{route('ajax.block.list')}}",
                    type: 'POST',
                    data: {'district_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select block</option>`));
                            $("#block_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                                $("#block_id").append($option);
                            });

                            $("#block_id").select2();
                        } else {
                            $("#block_id").append($_option);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#block_id").on("change", function () {
                let $_option = `<option value="1">Demo Pincode</option>`;

                $("#pincode_id").empty();
                $.ajax({
                    url: "{{route('ajax.pincode.list')}}",
                    type: 'POST',
                    data: {'block_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select pincode</option>`));
                            $("#pincode_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.pincode}</option>`));
                                $("#pincode_id").append($option);
                            });

                            $("#pincode_id").select2();
                        } else {
                            $("#pincode_id").append($_option);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            $("#pincode_id").on("change", function () {
                let $_option = `<option value="1">Demo Area</option>`;

                $("#area_id").empty();
                $.ajax({
                    url: "{{route('ajax.area.list')}}",
                    type: 'POST',
                    data: {'pincode_id': $(this).val()},
                    dataType: 'json',
                    success: function (res) {
                        if (res.response === "success") {
                            let option = $($.parseHTML(`<option value="">Select area</option>`));
                            $("#area_id").append(option);
                            $.each(res.data, function (key, item) {
                                let $option = $($.parseHTML(`<option value="${item.id}">${item.area}</option>`));
                                $("#area_id").append($option);
                            });

                            $("#area_id").select2();
                        } else {
                            $("#area_id").append($_option);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            });

            const makePayment = () => {
                let amount = "{{ $grandTotal }}";
                let name = "{{ auth()->user()->name }}";
                let email = "{{ auth()->user()->email }}";
                let mobile = "{{ auth()->user()->mobile }}";
                let totalAmount = amount * 100;
                var options = {
                    "key": "{{ env('RAZOR_KEY') }}",
                    "amount": totalAmount,
                    "currency": "INR",
                    "name": "Krishak Vikas",
                    "description": "Order Payment",
                    "image": "",
                    "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    "handler": function (response) {
                        placeOrder(response.razorpay_payment_id)
                    },
                    "prefill": {
                        "name": name,
                        "email": email,
                        "contact": mobile
                    },
                    "theme": {
                        "color": "#008000"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }

            const renderUserAddresses = data => {
                let addresses = `<div class="row">`;
                $.each(data, (i, e) => {
                    let address = e.address ? e.address : '';
                    let line2 = e.address_line_two ? e.address_line_two : '';
                    let landmark = e.street ? e.street : '';
                    let area = e.area ? e.area.area : '';
                    let block = e.block ? e.block.name : '';
                    let district = e.district ? e.district.name : '';
                    let state = e.state ? e.state.name : '';
                    let pincode = e.pincode ? e.pincode.pincode : '';
                    addresses += `<div class="col-sm-12 col-md-6 col-lg-4 d-flex">` +
                        `<div class="card select-address ${selectedAddress == e.id ? 'selected-address border-info' : ''}" data-id="${e.id}" style="width: 18rem; cursor: pointer">` +
                        `<div class="card-body">` +
                        `<div>Address: ${address}</div>` +
                        `<div>Line2: ${line2}</div>` +
                        `<div>Landmark: ${landmark}</div>` +
                        `<div class="font-weight-bolder">Area: ${area}</div>` +
                        `<div>${block}, ${district}, ${state} - ${pincode}</div>` +
                        `</div></div></div>`
                });
                addresses += `</div>`;
                $('#address-data').html(addresses);

            }
            const getUserAddresses = userId => {
                $.get("{{ route('helpCenter.get.user.addresses') }}", {userId}, result => {
                    renderUserAddresses(result.data);
                }, 'json');
            }

            $(document).on('click', '.select-user', function () {
                selectedUser = "";
                selectedAddress = "";
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected border-info');
                } else {
                    $(this).addClass('selected border-info');
                    selectedUser = $(this).data('id');
                }
                $('.select-user').not(this).removeClass('border-info selected')
                getUserAddresses(selectedUser)
            });

            $(document).on('click', '.select-address', function () {
                if ($(this).hasClass('selected-address')) {
                    $(this).removeClass('selected-address border-info');
                    selectedAddress = "";
                } else {
                    $(this).addClass('selected-address border-info');
                    selectedAddress = $(this).data('id');
                }
                $('.select-address').not(this).removeClass('border-info selected-address')
            });

            const renderUsersCard = data => {
                let users = `<div class="row">`;
                $.each(data, (i, e) => {
                    users += `<div class="col-sm-12 col-md-6 col-lg-4 d-flex">` +
                        `<div class="card select-user ${selectedUser == e.id ? 'selected border-info' : ''}" data-id="${e.id}" style="width: 18rem; cursor: pointer">` +
                        `<div class="card-body">` +
                        `<h5 class="card-title">${e.name}</h5>` +
                        `<ul class="list-group list-group-flush">` +
                        `<li class="list-group-item">${e.mobile}</li>` +
                        `<li class="list-group-item">${e.email}</li>` +
                        `</ul>` +
                        `</div></div></div>`
                });
                users += `</div>`;
                $('#data').html(users);
            }

            const getUsers = () => {
                let term = $('#term').val();
                $.get("{{ route('helpCenter.checkout.page') }}", {term}, result => {
                    renderUsersCard(result.data)
                });
            }
            getUsers();
            $(document).on('blur', '#term', () => getUsers());

            const placeOrder = (razorpay_payment_id = '') => {
                let userId = selectedUser;
                let addressId = selectedAddress;
                $('#place-order-button').prop('disabled', true);
                let paymentMethod = $('.payment-method:checked').val();
                $.post("{{ route('helpCenter.place.order') }}", {userId, addressId, paymentMethod, razorpay_payment_id}, result => {
                    alert(result.message)
                    $('#place-order-button').prop('disabled', false);
                    if (result.status) {
                        window.location = "{{ route('helpCenter.orders.index') }}";
                    }
                })
            }

            $(document).on('click', '#place-order-button', () => {
                if (selectedUser == "") {
                    alert('Please select former.')
                } else if (selectedAddress == "") {
                    alert('Please select address.')
                } else if (!$('.payment-method').is(':checked')) {
                    alert('Please select payment method.')
                } else {
                    let paymentMethod = $('.payment-method:checked').val();
                    if(paymentMethod == 'ONLINE') {
                        makePayment();
                    }else{
                        placeOrder();
                    }

                }
            });

            $('#addressForm').submit(function (event) {
                event.preventDefault();
                let data = $(this).serializeArray();
                data.push({name: "user_id", value: selectedUser})
                $.post("{{ route('helpCenter.add.user.address') }}", data, result => {
                    if (result.errors) {
                        $.each(result.errors, function (index, item) {
                            $(`#${index}`).addClass("is-invalid");
                            $(`#${index}`).next('.invalid-feedback').text(item[0]);
                        })
                    }else{
                        if(result.status){
                            $('#addModal').modal('hide');
                            $("#addressForm").trigger('reset');
                            getUserAddresses(selectedUser);
                        }else{
                            alert(result.message);
                        }
                    }
                }, 'json')


            });

        });

    </script>
@endsection
