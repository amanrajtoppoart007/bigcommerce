@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.bill.title_singular') }}
        </div>

        <div class="card-body">
            <form id="billForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required" for="vendor_id">{{ trans('cruds.bill.fields.vendor') }}</label>
                            <select class="form-control select2 {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}"
                                    name="vendor_id" id="vendor_id" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach($vendors as $id => $vendor)
                                    <option
                                        value="{{ $id }}" {{ old('vendor_id') == $id ? 'selected' : '' }}>{{ $vendor }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vendor_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vendor_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="voucher_date">{{ trans('cruds.bill.fields.voucher_date') }}</label>
                            <input class="form-control {{ $errors->has('voucher_date') ? 'is-invalid' : '' }}"
                                   type="date" name="voucher_date" id="voucher_date"
                                   value="{{ old('voucher_date', '') }}">
                            @if($errors->has('voucher_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('voucher_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="voucher_number">{{ trans('cruds.bill.fields.voucher_number') }}</label>
                            <input class="form-control {{ $errors->has('voucher_number') ? 'is-invalid' : '' }}"
                                   type="text" name="voucher_number" id="voucher_number"
                                   value="{{ old('voucher_number', '') }}">
                            @if($errors->has('voucher_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('voucher_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.bill.fields.bill_amount') }}</label>
                            <input class="form-control {{ $errors->has('bill_amount') ? 'is-invalid' : '' }}"
                                   type="text" name="bill_amount" id="bill_amount"
                                   value="{{ old('bill_amount', '') }}">
                            @if($errors->has('bill_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bill_amount') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="max-width: 350px">{{ trans('cruds.billItem.fields.product') }} <span class="text-danger">*</span></th>
                                    <th>{{ trans('cruds.billItem.fields.unit') }} <span class="text-danger">*</span></th>
                                    <th>{{ trans('cruds.billItem.fields.quantity') }} <span class="text-danger">*</span></th>
                                    <th>{{ trans('cruds.billItem.fields.price') }}</th>
                                    <th>
                                        <button type="button" class="btn btn-success" id="add-button" title="Add more item"><i
                                                class="fa fa-plus"></i></button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control select2 product_id" name="product_id[]" required
                                                style="max-width: 200px">
                                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2 product_price_id" name="product_price_id[]"
                                                required>
                                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control quantity" type="number"
                                               name="quantity[]" style="min-width: 100px" required>
                                    </td>
                                    <td>
                                        <input class="form-control price" type="number"
                                               name="price[]" style="min-width: 100px">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-button" title="remove item"><i
                                                class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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

    <script>
        $(function () {

            const makeSearchableSelect2 = () => {
                $('.product_id:last').select2({
                    placeholder: "{{ trans('global.pleaseSelect') }}",
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ route('ajax.products.search.select2') }}',
                        dataType: 'json',
                        type: 'GET',
                        processResults({data}) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.name,
                                        id: item.id,
                                    }
                                })
                            }
                        }
                    }
                });
            }
            makeSearchableSelect2();

            const addItemTemplate = () => {

                let tr = `<tr>` +
                    `<td><select class="form-control select2 product_id" name="product_id[]" required><option value="">{{ trans('global.pleaseSelect') }}</option></select></td>` +
                    `<td><select class="form-control select2 product_price_id" name="product_price_id[]" required><option value="">{{ trans('global.pleaseSelect') }}</option></select></td>` +
                    `<td><input class="form-control quantity" type="number" name="quantity[]" style="min-width: 100px" required></td>` +
                    `<td><input class="form-control price" type="number" name="price[]" value="0" style="min-width: 100px" required></td>` +
                    `<td><button type="button" class="btn btn-danger remove-button" title="remove item"><i class="fa fa-minus"></i></button></td>` +
                    `</tr>`;
                $('table tbody').append(tr);
                makeSearchableSelect2();
                $('.product_price_id:last').select2();
            }

            $(document).on('click', '#add-button', function () {
                addItemTemplate()
            });

            $(document).on('click', '.remove-button', function () {
                if ($('table tbody tr').length > 1) {
                    if (confirm('Are sure want to remove?')) {
                        $(this).closest('tr').remove();
                    }
                }
            });


            const renderProductUnits = (data) => {
                let productUnits = `<option value="">{{ trans('global.pleaseSelect') }}</option>`;
                $.each(data, (i, e) => {
                    productUnits += `<option value="${e.id}">${e.quantity} ${e.unit}</option>`;
                });
                $('.product_price_id:last').html(productUnits);
            }

            $(document).on('change', '.product_id', function () {
                let productId = $(this).val();
                $.get("{{ route('ajax.products.price.by.product') }}", {productId}, result => {
                    renderProductUnits(result.data)
                }, 'json');
            });


            $('#billForm').submit(function (event) {
                event.preventDefault();
                const validated = $($('.price, .quantity')).filter(function () {
                    return $(this).val() > 1
                }).length > 0;
                const isEmpty = $('table tbody tr').length < 1
                if (validated && !isEmpty) {
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: "{{ route("admin.bills.store") }}",
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                            alert(result.msg);
                            if (result.status) {
                                setTimeout(function () {
                                    window.location = "{{ route('admin.bills.index') }}"
                                }, 100);
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
