@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.franchiseeOrder.title_singular') }}
            <div class="float-right">
                <a class="btn btn-default" href="{{ route('admin.franchisee-orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                @if($franchiseeOrder->status != 'CANCELLED' || $franchiseeOrder->status != 'RECEIVED')
                    <button type="button" class="btn btn-warning" id="status-button" data-toggle="modal"
                            data-target="#statusModal">{{ trans('global.update_status') }}</button>
                @endif
                @if(!$franchiseeOrder->is_stock_updated)
                    <button class="btn btn-danger"
                            id="update-stock-button">{{ trans('global.update_stock') }}</button>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.order_number') }}
                            : </label>
                        <span>{{ $franchiseeOrder->order_number }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.status') }}: </label>
                    <span>{{ $franchiseeOrder->status }}</span>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('global.date') }}: </label>
                    <span>{{ date('d-m-Y', strtotime($franchiseeOrder->created_at)) }}</span>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_type') }}
                            : </label>
                        <span>{{ $franchiseeOrder->payment_type }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_status') }}: </label>
                    <span>{{ $franchiseeOrder->payment_status }}</span>
                    @if(!$franchiseeOrder->is_payment_verified)
                        <button class="btn btn-xs btn-danger" id="verify-payment-button">Verify</button>
                    @endif
                </div>
            </div>
            <hr>
            <h6>{{ trans('cruds.franchiseeOrderItem.title_singular') }} {{ trans('global.list') }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="min-width: 150px; max-width: 200px">{{ trans('cruds.franchiseeOrderItem.fields.product') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.product_unit') }}</th>
                        <th>{{ trans('cruds.masterStock.fields.stock') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.quantity') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.price') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.gst') }}</th>
                        <th colspan="2">{{ trans('cruds.franchiseeOrderItem.fields.discount') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.total_amount') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($franchiseeOrder->orderItems  as $orderItem)
                        @php $stock =  \App\Traits\ProductTrait::checkMasterStock($orderItem->product_price_id) @endphp
                        <tr class="{{ $stock >= $orderItem->quantity ? '' : 'bg-danger' }}">
                            <td>
                                {{ $orderItem->product->name }}
                            </td>
                            <td>
                                {{ $orderItem->unit_quantity . ' ' . $orderItem->unit }}
                            </td>
                            <td>
                                {{ $stock }}
                            </td>
                            <td>
                                {{ $orderItem->quantity }}
                            </td>
                            <td>
                                &#8377;{{ $orderItem->price }}
                            </td>
                            <td>
                                {{ $orderItem->gst }}%
                            </td>
                            <td>
                                {{ $orderItem->discount }}%
                            </td>
                            <td>
                                &#8377;{{ $orderItem->discount_amount }}
                            </td>
                            <td>
                                &#8377;{{ $orderItem->total_amount }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.sub_total') }}: <span
                                class="pull-right">&#8377;{{ $franchiseeOrder->amount }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.gst') }}: <span
                                class="text-danger pull-right">+ &#8377;{{ $franchiseeOrder->gst }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.discount') }}: <span
                                class="text-success pull-right">- &#8377;{{ $franchiseeOrder->discount }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.grand_total') }}: <span
                                class="pull-right">&#8377;{{ $franchiseeOrder->total_amount }}</span></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('global.update_status') }}</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form id="statusForm">
                    <input type="hidden" name="id" id="id" value="{{ $franchiseeOrder->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required"
                                   for="status">{{ trans('cruds.franchiseeOrder.fields.status') }}</label>
                            <select class="custom-select select2" name="status">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\FranchiseeOrder::STATUS_SELECT_FOR_ADMIN as $key => $item)
                                    <option
                                        value="{{ $key }}" {{ $franchiseeOrder->status == $key ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                    </div>
                </form>
            </div>
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
            let orderId = "{{ $franchiseeOrder->id }}";
            $('#update-stock-button').click(() => {
                $.post("{{ route('admin.franchisee-orders.update.stock') }}", {orderId}, result => {
                    alert(result.message);
                    if (result.status) {
                        location.reload();
                    }
                }, 'json');
            });

            $('#statusForm').submit(function (event) {
                event.preventDefault();

                $.post("{{ route("admin.franchisee-orders.update.status") }}", $(this).serialize(), result => {
                    alert(result.message);
                    if (result.status) {
                        location.reload()
                    }
                }, 'json')
            });

            $('#verify-payment-button').click(() => {
                if (confirm('Are you sure want to verify payment?')) {
                    $.post("{{ route('admin.franchisee-orders.verify.payment') }}", {orderId}, result => {
                        alert(result.message)
                        if (result.status) {
                            location.reload();
                        }
                    }, 'json')
                }
            });
        });
    </script>
@endsection
