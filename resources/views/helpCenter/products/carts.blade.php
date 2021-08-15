@extends('helpCenter.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ trans('cruds.cart.fields.cart_number') }}</th>
                        <th>{{ trans('cruds.cart.fields.product') }}</th>
                        <th>{{ trans('cruds.cart.fields.unit') }}</th>
                        <th>{{ trans('cruds.cart.fields.amount') }}</th>
                        <th style="min-width: 200px">{{ trans('cruds.cart.fields.quantity') }}</th>
                        <th>{{ trans('cruds.cart.fields.gst') }}</th>
                        <th style="min-width: 50px">{{ trans('cruds.cart.fields.discount') }}</th>
                        <th>{{ trans('cruds.cart.fields.total_amount') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $subTotal = $totalDiscount = $grandTotal = 0; @endphp
                    @forelse($carts as $cart)
                        @php $subTotal += ($cart->amount * $cart->quantity) @endphp
                        @php $totalDiscount += ($cart->amount * $cart->quantity) * $cart->discount / 100 @endphp
                        @php $grandTotal += ($cart->amount * $cart->quantity) - ($cart->amount * $cart->quantity) * $cart->discount / 100 @endphp
                        <tr>
                            <td>{{ $cart->cart_number }}</td>
                            <td>{{ $cart->product->name }}</td>
                            <td>{{ $cart->unit_quantity . ' ' . $cart->unit }}</td>
                            <td class="amount">{{ $cart->amount }}</td>
                            <td style="min-width: 200px">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-danger qty-minus-btn"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" class="form-control quantity" data-id="{{ $cart->id }}"
                                           value="{{ $cart->quantity }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger qty-plus-btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $cart->gst }}</td>
                            <td class="discount" hidden>{{ $cart->discount }}</td>
                            <td><span class="discount_amount">{{ ($cart->amount * $cart->quantity) * $cart->discount / 100 }}</span> ({{ $cart->discount }}%)</td>
                            <td class="total_amount">{{ ($cart->amount * $cart->quantity) - (($cart->amount * $cart->quantity) * $cart->discount / 100) }}</td>
                            <td>
                                <button data-id="{{ $cart->id }}" class="btn btn-danger remove-from-cart-button">
                                    {{ trans('global.remove') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-danger">{{ trans('global.cart_empty') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if(count($carts))
                <div class="row mb-3">
                    <div class="col"></div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-6 text-right">
                                {{ trans('cruds.cart.fields.subtotal') }}:
                            </div>
                            <div class="col-6 font-weight-bolder" id="sub-total">
                                {{ $subTotal }}
                            </div>
                            <div class="col-6 text-right">
                                {{ trans('cruds.cart.fields.total_discount') }}:
                            </div>
                            <div class="col-6 font-weight-bolder" id="discount">
                                {{ $totalDiscount }}
                            </div>
                            <div class="col-6 text-right">
                                {{ trans('cruds.cart.fields.total_gst') }}:
                            </div>
                            <div class="col-6 font-weight-bolder">
                                0
                            </div>
                            <div class="col-6 text-right">
                                {{ trans('cruds.cart.fields.grand_total') }}:
                            </div>
                            <div class="col-6 font-weight-bolder" id="grand-total">
                                {{ $grandTotal }}
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('helpCenter.checkout.page') }}"
                   class="btn btn-success">{{ trans('global.checkout') }}</a>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const calculateTr = tr => {
                let quantity = parseFloat($(tr).find('.quantity').val());
                let amount = parseFloat($(tr).find('.amount').text());
                let discount = parseFloat($(tr).find('.discount').text());
                let discountAmount = (quantity * amount) * discount / 100;
                let subTotal = (quantity * amount);
                $(tr).find('.total_amount').text(subTotal - discountAmount)
                $(tr).find('.discount_amount').text(discountAmount);
                calculate();
            }

            const calculate = () => {
                let subTotal = 0;
                let totalDiscount = 0;
                $('table tbody tr').each(function () {
                    let amount = parseFloat($(this).find('.amount').text());
                    let quantity = parseInt($(this).find('.quantity').val());
                    let discount = parseFloat($(this).find('.discount').text());
                    let discountAmount = 0;

                    let total = amount * quantity;
                    if (discount > 0) {
                        discountAmount = (total * discount) / 100;
                    }
                    subTotal += amount * quantity;
                    totalDiscount += discountAmount;
                });

                $('#sub-total').text(subTotal);
                $('#discount').text(totalDiscount);
                $('#grand-total').text(subTotal - totalDiscount);
            }

            const updateQuantity = (cartId, quantity) => {
                $.post("{{ route('helpCenter.update.cart.quantity') }}", {cartId, quantity}, result => {
                    if (!result.status) {
                        alert(result.message);
                    }
                }, 'json');
            }

            $(document).on('click', '.remove-from-cart-button', function () {
                let id = $(this).data('id');
                if (confirm("Are you sure want remove?")) {
                    $.post("{{ route('helpCenter.remove.from.cart') }}", {id}, result => {
                        if (result.status) {
                            location.reload();
                        }
                        alert(result.message);
                    }, 'json');
                }
            });

            $(document).on('blur', '.quantity', function () {
                let tr = $(this).closest('tr');
                let qty = $(this).val();
                if (qty < 0) $(this).val(1)
                calculateTr(tr);
            });

            $(document).on('change', '.quantity', function () {
                let tr = $(this).closest('tr');
                let qty = $(this).val();
                let cartId = $(this).data('id');
                updateQuantity(cartId, qty);
                calculateTr(tr);
            });

            $(document).on('click', '.qty-plus-btn', function () {
                let quantity = $(this).closest('tr').find('.quantity');
                $(quantity).val(parseFloat($(quantity).val()) + 1).trigger('change');
            });
            $(document).on('click', '.qty-minus-btn', function () {
                let quantity = $(this).closest('tr').find('.quantity');
                if ($(quantity).val() > 1) {
                    $(quantity).val(parseFloat($(quantity).val()) - 1).trigger('change');
                }

            });
        });

    </script>
@endsection
