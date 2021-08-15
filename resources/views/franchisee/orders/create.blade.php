@extends('franchisee.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.franchiseeOrder.title_singular') }}
        </div>

        <div class="card-body">
            <form id="orderForm" enctype="multipart/form-data">
                @csrf
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.product') }}</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.product_unit') }}</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.price') }}</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.quantity') }}</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.gst') }} %</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.discount') }} %</th>
                            <th>{{ trans('cruds.franchiseeOrderItem.fields.total_amount') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <select class="form-control select2 product_id" name="product_id[]" required style="max-width: 200px">
                                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2 product_price_id" name="product_price_id[]"
                                        required>
                                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control price" type="number"
                                       name="price[]" value="0" style="min-width: 100px" readonly required>
                            </td>

                            <td style="min-width: 200px">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-danger d-inline qty-minus-btn"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="number" step="1" class="form-control quantity d-inline"
                                           value="1" name="quantity[]" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger d-inline qty-plus-btn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input class="form-control gst" type="number" value="0"
                                       name="gst[]" style="min-width: 100px" readonly required>
                            </td>
                            <td>
                                <input class="form-control discount" type="number"
                                       name="discount[]" value="0" style="min-width: 100px" readonly required>
                            </td>
                            <td>
                                <input class="form-control total_amount" type="number"
                                       name="total_amount[]" value="0" style="min-width: 100px" readonly required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success add-button" title="Add more item"><i
                                        class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="from-group">
                            <label for="sub_total">Sub Total</label>
                            <input class="form-control" type="number"
                                   name="sub_total" id="sub_total" value="0" readonly required>
                        </div>
                        <div class="from-group">
                            <label for="total_gst">GST</label>
                            <input class="form-control" type="number"
                                   name="total_gst" value="0" readonly required>
                        </div>
                        <div class="from-group">
                            <label for="total_discount">Discount</label>
                            <input class="form-control" type="number"
                                   name="total_discount" id="total_discount" value="0" readonly required>
                        </div>
                        <div class="from-group">
                            <label for="grand_total">Total Amount</label>
                            <input class="form-control" type="number"
                                   name="grand_total" id="grand_total" value="0" readonly required>
                        </div>
                        <div class="from-group">
                            <label
                                class="required">{{ trans('cruds.helpCenterProfile.fields.payment_method') }}</label>

                            @foreach(App\Models\Order::PAYMENT_TYPE_SELECT as $key => $label)
                                <div class="form-check {{ $errors->has('payment_method') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input payment-method" type="radio"
                                           id="payment_method_{{ $key }}"
                                           name="payment_method" value="{{ $key }}" required>
                                    <label class="form-check-label" for="payment_method_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
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
    @parent
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(function () {

            const addItemTemplate = () => {
                let products = <?= json_encode($products) ?>;
                let productSelectOptions = `<option value="">{{ trans('global.pleaseSelect') }}</option>`;
                $.each(products, (i, e) => {
                    productSelectOptions += `<option value="${e.id}">${e.name}</option>`;
                });
                let tr = `<tr>` +
                    `<td><select class="form-control select2 product_id" name="product_id[]" required>${productSelectOptions}</select></td>` +
                    `<td><select class="form-control select2 product_price_id" name="product_price_id[]" required><option value="">{{ trans('global.pleaseSelect') }}</option></select></td>` +
                    `<td><input class="form-control price" type="number" name="price[]" value="0" style="min-width: 100px" readonly required></td>` +
                    `<td style="min-width: 200px"><div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-danger d-inline qty-minus-btn"><i class="fa fa-minus"></i></button>
                        </div>
                        <input type="number" step="1" class="form-control quantity d-inline"
                               value="1" name="quantity[]" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger d-inline qty-plus-btn"><i class="fa fa-plus"></i></button>
                            </div>
                    </div></td>` +
                    `<td><input class="form-control gst" type="number" value="0" name="gst[]" style="min-width: 100px" readonly required></td>` +
                    `<td><input class="form-control discount" type="number" name="discount[]" value="0" style="min-width: 100px" readonly required></td>` +
                    `<td><input class="form-control total_amount" type="number" name="total_amount[]" value="0" style="min-width: 100px" readonly required></td>` +
                    `<td><button type="button" class="btn btn-success add-button" title="Add more item"><i class="fa fa-plus"></i></button></td>` +
                    `</tr>`;
                $('table tbody').append(tr);
                $('.product_id:last').select2();
                $('.product_price_id:last').select2();
            }

            $(document).on('click', '.add-button', function () {

                let isNotEmpty = $($(this).closest('tr').find('.price, .quantity')).filter(function () {
                    return $(this).val() > 1
                }).length > 0;

                if (isNotEmpty) {
                    addItemTemplate()
                    let deleteButton = '<button type="button" class="btn btn-danger delete-button"><i class="fa fa-trash"></i></button>';
                    $(this).parent().append(deleteButton);
                    $(this).remove();
                }
            });

            $(document).on('click', '.delete-button', function () {
                if (confirm('Are sure want to remove?')) {
                    $(this).closest('tr').remove();
                }
            });

            const calculateTr = tr => {
                let price = parseFloat($(tr).find('.price').val());
                let quantity = parseInt($(tr).find('.quantity').val());
                let discount = parseFloat($(tr).find('.discount').val());
                let subTotal = price * quantity;
                let discountAmount = 0;
                if (discount > 0) {
                    discountAmount = (subTotal * discount) / 100;
                }
                $(tr).find('.total_amount').val(subTotal - discountAmount);
                calculate();
            }

            const calculate = () => {
                let subTotal = 0;
                let totalDiscount = 0;
                $('table tbody tr').each(function () {
                    let price = parseFloat($(this).find('.price').val());
                    let quantity = parseInt($(this).find('.quantity').val());
                    let discount = parseFloat($(this).find('.discount').val());
                    let discountAmount = 0;

                    let total = price * quantity;
                    if (discount > 0) {
                        discountAmount = (total * discount) / 100;
                    }
                    subTotal += price * quantity;
                    totalDiscount += discountAmount;

                });

                $('#sub_total').val(subTotal);
                $('#total_discount').val(totalDiscount);
                $('#grand_total').val(subTotal - totalDiscount);
            }

            $(document).on('change', '.quantity', function () {
                let tr = $(this).closest('tr');
                if ($(this).val() == '' || $(this).val() == 0) {
                    $(this).val(1);
                }
                calculateTr(tr);
            });

            $(document).on('click', '.qty-plus-btn', function () {
                let quantity = $(this).closest('td').find('.quantity');
                $(quantity).val(parseFloat($(quantity).val()) + 1).trigger('change');
            });
            $(document).on('click', '.qty-minus-btn', function () {
                let quantity = $(this).closest('td').find('.quantity');
                $(quantity).val(parseFloat($(quantity).val()) - 1).trigger('change');
            });

            const renderProductUnits = (data) => {
                let productUnits = `<option value="">{{ trans('global.pleaseSelect') }}</option>`;
                $.each(data, (i, e) => {
                    productUnits += `<option value="${e.id}" data-price="${e.bulk_price}" data-discount="${e.bulk_discount}">${e.quantity} ${e.unit}</option>`;
                });
                $('.product_price_id:last').html(productUnits);
            }

            $(document).on('change', '.product_id', function () {
                $(this).closest('tr').find('input:not(.quantity)').val(0);
                let productId = $(this).val();
                $.get("{{ route('franchisee.get.product.prices.by.product') }}", {productId}, result => {
                    renderProductUnits(result.data)
                }, 'json');
                calculate();
            });

            $(document).on('change', '.product_price_id', function () {
                let tr = $(this).closest('tr');
                if ($(this).val() != '') {
                    $(tr).find('.price').val($(this).select2('data')[0].element.attributes[1].nodeValue);
                    $(tr).find('.discount').val($(this).select2('data')[0].element.attributes[2].nodeValue);
                } else {
                    $(tr).find('.price').val(0);
                    $(tr).find('.discount').val(0);
                }

                calculateTr(tr)
            });

            const makePayment = (lastResponse) => {
                let orderId = lastResponse.order_id;
                let amount = lastResponse.amount;
                let name = lastResponse.user.name;
                let email = lastResponse.user.email;
                let mobile = lastResponse.user.mobile;
                let totalAmount = amount * 100;
                var options = {
                    "key": "{{ env('RAZOR_KEY') }}",
                    "amount": totalAmount,
                    "currency": "INR",
                    "name": "Krishak Vikas",
                    "description": "Membership payment",
                    "image": "",
                    "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    "handler": function (response) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('franchisee.make.order.payment') }}",
                            data: {
                                razorpay_payment_id: response.razorpay_payment_id,
                                amount,
                                orderId
                            },
                            success: function (data) {
                                alert(data.message);
                                window.location = "{{ route('franchisee.orders.index') }}"
                            }
                        });
                    },
                    "prefill": {
                        "name": name,
                        "email": email,
                        "contact": mobile
                    },
                    "theme": {
                        "color": "#14587c"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }

            $('#orderForm').submit(function (event) {
                event.preventDefault();
                const validated = $($('.price, .quantity')).filter(function () {
                    return $(this).val() > 1
                }).length > 0;
                if (validated) {
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: "{{ route("franchisee.orders.store") }}",
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                            if (result.status) {
                                console.log(result)
                                if ($('#payment_method_ONLINE').is(':checked')) {
                                    makePayment(result)
                                } else {
                                    alert(result.msg);
                                    setTimeout(function () {
                                        window.location = "{{ route('franchisee.orders.index') }}"
                                    }, 100);
                                }

                            } else {
                                alert(result);
                            }
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                } else {
                    alert('Please fill all the required fields.');
                }
            });
        });
    </script>
@endsection
