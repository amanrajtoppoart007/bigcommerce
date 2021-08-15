@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">

            {{ trans('global.show') }} {{ trans('cruds.bill.title_singular') }}
            <div class="float-right">
                <a class="btn btn-default" href="{{ route('admin.bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.bill.fields.vendor') }}: </label>
                        <span>{{ $bill->vendor->name ?? '' }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.vendor.fields.mobile') }}: </label>
                        <span>{{ $bill->vendor->mobile ?? '' }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.vendor.fields.email') }}: </label>
                        <span>{{ $bill->vendor->email ?? '' }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.bill.fields.voucher_date') }}: </label>
                    <span>{{ $bill->voucher_date ?? '' }}</span>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bolder">{{ trans('cruds.bill.fields.voucher_number') }}: </label>
                    <span>{{ $bill->voucher_number ?? '' }}</span>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bolder">{{ trans('cruds.bill.fields.bill_amount') }}: </label>
                        <span>&#8377;{{ $bill->bill_amount ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <hr>
            <h6>{{ trans('cruds.billItem.title_singular') }} {{ trans('global.list') }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="min-width: 150px; max-width: 200px">{{ trans('cruds.billItem.fields.product') }}</th>
                        <th>{{ trans('cruds.billItem.fields.unit') }}</th>
                        <th>{{ trans('cruds.billItem.fields.price') }}</th>
                        <th>{{ trans('cruds.billItem.fields.quantity') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bill->billItems  as $billItem)
                        <tr>
                            <td>
                                {{ $billItem->product->name ?? '' }}
                            </td>
                            <td>
                                {{ $billItem->unit_quantity . ' ' . $billItem->unit }}
                            </td>
                            <td>
                                &#8377;{{ $billItem->price ?? 0 }}
                            </td>
                            <td>
                                {{ $billItem->quantity ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
