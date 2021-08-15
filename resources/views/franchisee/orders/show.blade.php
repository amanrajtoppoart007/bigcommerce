@extends('franchisee.layout.main')
@section('content')

    <div class="card">
        <div class="card-header">

            {{ trans('global.show') }} {{ trans('cruds.franchiseeOrder.title_singular') }}
            <div class="float-right">
                <a class="btn btn-default" href="{{ route('franchisee.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                @if(strtoupper($franchiseeOrder->status) == "PENDING")
                    <button class="btn btn-danger" id="cancel-button">
                        {{ trans('global.cancel') }}
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.order_number') }}: </label>
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
                        <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_type') }}: </label>
                        <span>{{ $franchiseeOrder->payment_type }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.payment_status') }}: </label>
                    <span>{{ $franchiseeOrder->payment_status }}</span>
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
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.price') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.quantity') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.gst') }}</th>
                        <th colspan="2">{{ trans('cruds.franchiseeOrderItem.fields.discount') }}</th>
                        <th>{{ trans('cruds.franchiseeOrderItem.fields.total_amount') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($franchiseeOrder->orderItems  as $orderItem)
                        <tr>
                            <td>
                                {{ $orderItem->product->name }}
                            </td>
                            <td>
                                {{ $orderItem->unit_quantity . ' ' . $orderItem->unit }}
                            </td>
                            <td>
                                &#8377;{{ $orderItem->price }}
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
                        <th colspan="5">{{ trans('global.sub_total') }}: <span class="pull-right">&#8377;{{ $franchiseeOrder->amount }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.gst') }}: <span class="text-danger pull-right">+ &#8377;{{ $franchiseeOrder->gst }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.discount') }}: <span class="text-success pull-right">- &#8377;{{ $franchiseeOrder->discount }}</span></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="5">{{ trans('global.grand_total') }}: <span class="pull-right">&#8377;{{ $franchiseeOrder->total_amount }}</span></th>
                    </tr>
                    </tfoot>
                </table>
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

            $('#cancel-button').click(() => {
                if(confirm('Are you sure want to cancel the order?')){
                    $.post("{{ route('franchisee.orders.cancel') }}", {orderId}, result => {
                        alert(result.message)
                        if(result.status){
                            location.reload()
                        }
                    }, 'json');
                }
            })
        });

    </script>
@endsection
