@extends('franchisee.layout.main')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.productStock.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Order">
                <thead>
                <tr>
                    <th></th>
                    <th>
                        {{ trans('cruds.productStock.fields.product') }}
                    </th>
                    <th class="w-25">
                        {{ trans('cruds.productStock.fields.product_unit') }}
                    </th>
                    <th class="w-25">
                        {{ trans('cruds.productStock.fields.quantity') }}
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input class="search w-100" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search w-100" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search w-100" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
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
            let dtOverrideGlobals = {
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('franchisee.product-stocks.index') }}",
                columns: [
                    {data: 'placeholder', name: null},
                    {data: 'product_name', name: 'product.name', orderable:true},
                    {data: 'unit', name: 'unit'},
                    {data: 'quantity', name: 'quantity', orderable:true},
                ],
                orderCellsTop: true,
                pageLength: 10,
            };
            let table = $('.datatable-Order').DataTable(dtOverrideGlobals);


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
