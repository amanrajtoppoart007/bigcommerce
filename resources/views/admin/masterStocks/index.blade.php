@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.masterStock.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Order">
                <thead>
                <tr>
                    <th></th>
                    <th>
                        {{ trans('cruds.masterStock.fields.product') }}
                    </th>
                    <th>
                        {{ trans('cruds.masterStock.fields.product_unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.masterStock.fields.stock') }}
                    </th>
                    <th>
                        {{ trans('cruds.masterStock.fields.new_stock') }}
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
                            @foreach($units as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>

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
                ajax: "{{ route('admin.master-stocks.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'product.name', name: 'product.name'},
                    {data: 'unit', name: 'unit'},
                    {data: 'stock', name: 'stock'},
                    {data: 'new_stock', name: 'new_stock', orderable: false},
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

            const updateStock = (id, newStock) => {
                $.post("{{ route('admin.master-stocks.update.stock') }}", {id, newStock}, result => {
                    if (result.status) {
                        table.ajax.reload()
                    }else{
                        alert(result.msg)
                    }
                }, 'json')
            }

            $(document).on('click', '.apply-button', function () {
                let id = $(this).data('id');
                let stock = $(this).data('stock');
                let newStock = $(this).closest('tr').find('.new-stock').val();
                if (newStock == '') {
                    alert('Please enter new stock');
                } else {
                    if (confirm(`Are you sure want to apply new stock? old stock: ${stock}, new stock will be ${newStock}`)) {
                        updateStock(id, newStock);
                    }
                }
            })
        });

    </script>
@endsection
