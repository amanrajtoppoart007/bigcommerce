@extends("helpCenter.layout.main")
@section("content")
    <style>
        .underline-none {
            text-decoration: none !important;
        }
        .font-20 {
            font-size: 30px !important;
        }
    </style>
    <div class="content">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a href="{{ route('helpCenter.orders.index', ['status' => 'PENDING']) }}"
                   class="card text-white bg-danger text-center underline-none">
                    <div class="card-body pb-0">
                        <div class="text-value font-20">{{ $pendingOrdersCount }}</div>
                        <div>{{ trans('global.pending') . ' ' . trans('cruds.order.title') }}</div>
                        <br/>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a href="{{ route('helpCenter.orders.index') }}"
                   class="card text-white bg-success text-center underline-none">
                    <div class="card-body pb-0">
                        <div class="text-value font-20">{{ $totalOrdersCount }}</div>
                        <div>{{ trans('global.total') . ' ' . trans('cruds.order.title') }}</div>
                        <br/>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card text-white bg-dark text-center underline-none">
                    <div style="position:absolute; right: 5px; top: 0; text-align: right">
                        500 / 50000
                    </div>
                    <div class="card-body pb-0">
                        <div class="text-value font-20">&#8377;4500</div>
                        <div>{{ trans('global.credit_left') }}</div>
                        <br/>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a href="{{ route('helpCenter.products.index') }}"
                   class="card text-white bg-warning text-center underline-none">
                    <div class="card-body pb-0">
                        <div class="text-value font-20">{{ $productsCount }}</div>
                        <div>{{ trans('global.total') . ' ' . trans('cruds.product.title') }}</div>
                        <br/>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a href="{{ route('helpCenter.users.index') }}"
                   class="card text-white bg-primary text-center underline-none">
                    <div class="card-body pb-0">
                        <div class="text-value font-20">{{ $usersCount }}</div>
                        <div>{{ trans('global.total') . ' ' . trans('cruds.user.title') }}</div>
                        <br/>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a href="{{ route('helpCenter.carts') }}"
                   class="card text-white bg-info text-center underline-none">
                    <div class="card-body pb-0">
                        <div class="text-value font-20">{{ $cartsCount }}</div>
                        <div>{{ trans('global.total') . ' ' . trans('cruds.cart.title') }}</div>
                        <br/>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="mt-3 card" style="overflow-x: auto;">
                    <div class="card-header">
                        <h5 class="float-left">{{ trans('global.recent') }} {{ trans('cruds.order.title') }}</h5>
                        <div class="float-right">
                            <a class="btn btn-sm btn-info" href="{{ route('helpCenter.orders.index') }}">{{ trans('global.view_more') }}</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.order.fields.order_number') }}</th>
                            <th>{{ trans('cruds.order.fields.user') }}</th>
                            <th>{{ trans('cruds.order.fields.status') }}</th>
                            <th>{{ trans('global.date') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number ?? '' }}</td>
                                <td>{{ $order->user->name ?? '' }}</td>
                                <td>{{ $order->status ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                <td><a class="btn btn-xs btn-primary" href="{{ route('helpCenter.orders.show', $order->order_number) }}">{{ trans('global.view') }}</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text" colspan="5">{{ __('No entries found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="mt-3 card" style="overflow-x: auto;">
                    <div class="card-header">
                        <h5 class="float-left">{{ trans('global.recent') }} {{ trans('cruds.user.title') }}</h5>
                        <div class="float-right">
                            <a class="btn btn-sm btn-info" href="{{ route('helpCenter.users.index') }}">{{ trans('global.view_more') }}</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.user.fields.name') }}</th>
                            <th>{{ trans('cruds.user.fields.mobile') }}</th>
                            <th>{{ trans('cruds.user.fields.email') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name ?? '' }}</td>
                                <td>{{ $user->mobile ?? '' }}</td>
                                <td>{{ $user->email ?? '' }}</td>
                                <td><a class="btn btn-xs btn-primary" href="{{ route('helpCenter.users.show', $user->id) }}">{{ trans('global.view') }}</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text" colspan="5">{{ __('No entries found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
