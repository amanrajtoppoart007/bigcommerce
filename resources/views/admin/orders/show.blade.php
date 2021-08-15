@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
        <div class="float-right">
            <a class="btn btn-sm btn-default" href="{{ route('admin.orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            @if(strtoupper($order->status) == "PENDING")
                <button class="btn btn-sm btn-danger" id="cancel-button">
                    {{ trans('global.cancel') }}
                </button>
            @endif
            @if(strtoupper($order->status) == "CANCELLED" && strtoupper($order->payment_type) == "ONLINE" && strtoupper($order->payment_status) == "SUCCESS")
                <button class="btn btn-sm btn-danger" id="refund-button">
                    {{ trans('global.refund') }}
                </button>
            @endif
            @if($order->status != 'CANCELLED' || $order->status != 'RECEIVED')
                <button type="button" class="btn btn-sm btn-warning" id="status-button" data-toggle="modal" data-target="#statusModal">{{ trans('global.update_status') }}</button>
            @endif
            @if(!$order->franchisee_id)
                <button class="btn btn-sm btn-default" id="assign-button">
                    {{ trans('global.auto_assign') }}
                </button>
                <button class="btn btn-sm btn-default" id="manual-assign-button">
                    {{ trans('global.manual_assign') }}
                </button>
            @endif
            @if($order->is_invoice_generated)
                <a target="_blank" href="{{ route('orders.print.invoice', $order->invoice->invoice_number ?? '') }}" class="btn btn-sm btn-danger">
                    {{ trans('global.print') }} {{ trans('global.invoice') }}
                </a>
            @else
                <button class="btn btn-sm btn-danger" id="generate-invoice-button">
                    {{ trans('global.generate') }} {{ trans('global.invoice') }}
                </button>
            @endif
            @if(!$order->is_stock_updated)
                <button class="btn btn-sm btn-danger" id="update-stock-button">
                    {{ trans('global.update_stock') }}
                </button>
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
                @if(!$order->is_payment_verified)
                    <button class="btn btn-xs btn-danger" id="verify-payment-button">Verify</button>
                @endif
            </div>
            <div class="col-4">
                <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.help_center') }} ({{ trans('global.handling') }}): </label>
                <span>{{ $order->helpCenter->name ?? '' }}</span>
            </div>
            <div class="col-4">
                <label for="" class="font-weight-bolder">{{ trans('cruds.order.fields.assignee') }} ({{ trans('global.assigned_to') }}): </label>
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
                    <th>{{ trans('cruds.masterStock.fields.stock') }}</th>
                    <th>{{ trans('cruds.orderItem.fields.quantity') }}</th>
                    <th>{{ trans('cruds.orderItem.fields.amount') }}</th>
                    <th>{{ trans('cruds.orderItem.fields.gst') }}</th>
                    <th colspan="2">{{ trans('cruds.orderItem.fields.discount') }}</th>
                    <th>{{ trans('cruds.orderItem.fields.total_amount') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->orderItems  as $orderItem)
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
                            &#8377;{{ $orderItem->amount }}
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
                    <th colspan="5">{{ trans('global.sub_total') }}: <span class="pull-right">&#8377;{{ $order->sub_total }}</span></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="5">{{ trans('global.gst') }}: <span class="text-danger pull-right">+ &#8377;{{ $order->gst }}</span></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="5">{{ trans('global.discount') }}: <span class="text-success pull-right">- &#8377;{{ $order->discount }}</span></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="5">{{ trans('global.grand_total') }}: <span class="pull-right">&#8377;{{ $order->grand_total }}</span></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#order_transactions" role="tab" data-toggle="tab">
                {{ trans('cruds.transaction.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="order_transactions">
            @includeIf('admin.orders.relationships.orderTransactions', ['transactions' => $order->orderTransactions])
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="assignModal" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('global.select_franchisee') }}</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered" id="franchisee-table">
                    <thead>
                    <tr>
                        <th>{{ trans('cruds.franchisee.fields.name') }}</th>
                        <th>{{ trans('cruds.franchisee.fields.mobile') }}</th>
                        <th>{{ trans('cruds.franchiseeProfile.fields.representative_name') }}</th>
                        <th>{{ trans('cruds.franchiseeProfile.fields.representative_address') }}</th>
                        <th>{{ trans('global.representative') }} {{ trans('global.district') }} / {{ trans('global.block') }}</th>
                        <th>{{ trans('global.representative') }} {{ trans('global.pincode') }} / {{ trans('global.area') }}</th>
                        <th>{{ trans('global.select') }}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($franchisees as $franchisee)
                        <tr data-id="{{ $franchisee->id }}">
                            <td>{{ $franchisee->name ?? '' }}</td>
                            <td>{{ $franchisee->mobile ?? '' }}</td>
                            <td>{{ $franchisee->profile->representative_name ?? '' }}</td>
                            <td>{{ $franchisee->profile->representative_address ?? '' }}</td>
                            <td>{{ $franchisee->profile->representative_district->name ?? '' }} / {{ $franchisee->profile->representative_block->name ?? '' }}</td>
                            <td>{{ $franchisee->profile->representative_pincode->pincode ?? '' }} / {{ $franchisee->profile->representative_area->area ?? '' }}</td>
                            <td><button class="btn btn-sm btn-success select-button">{{ trans('global.select') }}</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('global.close') }}</button>
                <button class="btn btn-danger" id="select-assign-button">{{ trans('global.assign') }}</button>
            </div>
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
                        <label class="required" for="status">{{ trans('cruds.franchiseeOrder.fields.status') }}</label>
                        <select class="custom-select select2" name="status">
                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Order::STATUS_SELECT_FOR_ADMIN as $key => $item)
                                <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $item }}</option>
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

            let selectedFranchisee = "";

            $('#manual-assign-button').click(() => {
                selectedFranchisee = "";
                $('#franchisee-table tbody tr').removeClass('bg-success');
                $('#assignModal').modal('show');
            });

            $('#select-assign-button').click(() => {
                if(selectedFranchisee.length <= 0){
                    alert('Please select franchisee')
                }else{
                    $.post("{{ route('admin.orders.assign.manually') }}", {orderId, franchiseeId: selectedFranchisee}, result => {
                        alert(result.message)
                        if(result.status){
                            location.reload();
                        }
                    }, 'json')
                }
            });

            $(document).on('click', '#franchisee-table tbody tr', function (){
                let franchiseeId = $(this).data('id');
                $('#franchisee-table tbody tr').removeClass('bg-success');
                if(franchiseeId == selectedFranchisee){
                    selectedFranchisee = "";
                }else{
                    $(this).addClass('bg-success');
                    selectedFranchisee = franchiseeId;
                }
            });

            $('#assign-button').click(() => {
                $.post("{{ route('admin.orders.assign') }}", {orderId}, result => {
                    alert(result.message)
                    if(result.status){
                        location.reload();
                    }
                }, 'json')
            });

            $('#cancel-button').click(() => {
                if(confirm('Are you sure want to cancel this order?')){
                    $.post("{{ route('admin.orders.cancel') }}", {orderId}, result => {
                        alert(result.message)
                        if(result.status){
                            location.reload();
                        }
                    }, 'json')
                }
            });

            $('#verify-payment-button').click(() => {
                if(confirm('Are you sure want to verify payment?')){
                    $.post("{{ route('admin.orders.verify.payment') }}", {orderId}, result => {
                        alert(result.message)
                        if(result.status){
                            location.reload();
                        }
                    }, 'json')
                }
            });

            $('#generate-invoice-button').click(() => {
                $.post("{{ route('admin.orders.generate.invoice') }}", {orderId}, result => {
                    alert(result.message)
                    if (result.status) {
                        location.reload();
                    }
                }, 'json')
            });

            $('#statusForm').submit(function (event){
                event.preventDefault();

                $.post("{{ route("admin.orders.update.status") }}", $(this).serialize(), result => {
                    alert(result.message);
                    if(result.status){
                        location.reload()
                    }
                }, 'json')
            });

            $('#update-stock-button').click(() => {
                if(confirm('Are you sure want to update stock?')){
                    $.post("{{ route('admin.orders.update.stock') }}", {orderId}, result => {
                        alert(result.message)
                        if(result.status){
                            location.reload();
                        }
                    }, 'json')
                }
            });
        });

    </script>
@endsection
