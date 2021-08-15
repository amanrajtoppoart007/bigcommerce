@extends('franchisee.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('global.assigned_order') }}
            <div class="float-right">
                @if($order->status == "PENDING")
                    <span class="text-danger h6">{{ trans('global.confirm_stock_check') }}</span>
                @endif
                <a class="btn btn-default" href="{{ route('franchisee.assigned-orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                @if($order->status != "PENDING")
                    @if($order->status != 'CANCELLED' || $order->status != 'RECEIVED')
                        <button type="button" class="btn btn-danger" id="status-button" data-toggle="modal"
                                data-target="#statusModal">{{ trans('global.update_status') }}</button>
                    @endif
                @endif
                @if($order->status == "PENDING")
                    <button class="btn btn-success" id="confirm-button">{{ trans('global.confirm') }}</button>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.order_number') }}
                            : </label>
                        <span>{{ $order->order_number }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.status') }}: </label>
                    <span>{{ $order->status }}</span>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('global.date') }}: </label>
                    <span>{{ date('d-m-Y', strtotime($order->created_at)) }}</span>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_type') }}
                            : </label>
                        <span>{{ $order->payment_type }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_status') }}: </label>
                    <span>{{ $order->payment_status }}</span>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.assignee') }}: </label>
                    <span>{{ $order->assignee->name ?? 'Not Assigned' }}</span>
                </div>
            </div>
            <hr>
            <h6>{{ trans('cruds.orderItem.title_singular') }} {{ trans('global.list') }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="min-width: 150px; max-width: 200px">{{ trans('cruds.orderItem.fields.product') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.product_price') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.amount') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.quantity') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.gst') }}</th>
                        <th colspan="2">{{ trans('cruds.orderItem.fields.discount') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.total_amount') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems  as $orderItem)
                        <tr>
                            <td>
                                {{ $orderItem->product->name }}
                            </td>
                            <td>
                                {{ $orderItem->unit_quantity . ' ' . $orderItem->unit }}
                            </td>
                            <td>
                                &#8377;{{ $orderItem->amount }}
                            </td>
                            <td>
                                {{ $orderItem->quantity }}
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
                                class="pull-right">&#8377;{{ $order->sub_total }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.gst') }}: <span
                                class="text-danger pull-right">+ &#8377;{{ $order->gst }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.discount') }}: <span
                                class="text-success pull-right">- &#8377;{{ $order->discount }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.grand_total') }}: <span
                                class="pull-right">&#8377;{{ $order->grand_total }}</span></th>
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
                    <input type="hidden" name="id" id="id" value="{{ $order->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required"
                                   for="status">{{ trans('cruds.franchiseeOrder.fields.status') }}</label>
                            <select class="custom-select select2" name="status">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Order::STATUS_SELECT_FOR_FRANCHISEE as $key => $item)
                                    <option
                                        value="{{ $key }}" {{ $key == 'CONFIRMED' ? 'disabled' : '' }} {{ $order->status == $key ? 'selected' : '' }}>{{ $item }}</option>
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
            let orderId = "{{ $order->id }}";

            $('#statusForm').submit(function (event) {
                event.preventDefault();

                $.post("{{ route("franchisee.assigned-orders.update.status") }}", $(this).serialize(), result => {
                    alert(result.message);
                    if (result.status) {
                        location.reload()
                    }
                }, 'json')
            });

            $('#confirm-button').click(() => {
                if (confirm('Are you sure want to confirm?')){
                    $.post("{{ route("franchisee.assigned-orders.confirm") }}", {orderId}, result => {
                        alert(result.message);
                        if (result.status) {
                            location.reload()
                        }
                    }, 'json')
                }
            });
        });

    </script>
@endsection
