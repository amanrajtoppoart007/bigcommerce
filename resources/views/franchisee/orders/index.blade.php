@extends('franchisee.layout.main')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('franchisee.orders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.franchiseeOrder.title_singular') }}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.franchiseeOrder.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Order">
                <thead>
                <tr>
                    <th></th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.order_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.payment_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.gst') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.discount') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.total_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.franchiseeOrder.fields.status') }}
                    </th>
                    <th></th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\FranchiseeOrder::PAYMENT_TYPE_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\FranchiseeOrder::STATUS_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('franchisee.orders.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'order_number', name: 'order_number'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'amount', name: 'amount'},
                    {data: 'gst', name: 'gst'},
                    {data: 'discount', name: 'discount'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 10,
            };
            let table = $('.datatable-Order').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function (e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function (colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });

    </script>
@endsection
