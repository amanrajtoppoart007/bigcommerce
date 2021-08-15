@extends('layouts.admin')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.user.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.mobile') }}/{{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.help_center') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.approved') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.verified') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td></td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.users.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    let ids = $.map(dt.rows({selected: true}).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'contact', name: 'mobile'},
                    {data: 'help_center_name', name: 'help_center.name'},
                    {data: 'approved', name: 'approved'},
                    {data: 'verified', name: 'verified'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 10,
            };
            let table = $('.datatable-User').DataTable(dtOverrideGlobals);
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

            $(document).on('change', '.user-approval-status', function (e) {
                if (confirm("Are you sure want to change approved status?")) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        url: "{{route('admin.users.changeApprovalStatus')}}",
                        type: 'POST',
                        data: {
                            id: $(this).attr('data-id'),
                            status: $(this).attr('data-status')
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $("#overlay").show();
                        },
                        success: function (res) {
                            if (res.response === "success") {
                                $.notify(res.message, 'success', 'top-right');

                            } else {

                                $.notify(res.message, 'error', 'top-right');
                            }
                        },
                        error: function (jqXhr) {

                            let data = jqXhr.responseJSON;
                            if (data.errors) {
                                let error = '';
                                $.each(data.errors, function (index, item) {
                                    error += item[0] + "\n";
                                });

                                $.notify(error, 'error', 'top-right');
                            }

                        },

                        complete: function () {
                            $("#overlay").hide();
                        }
                    });
                } else {
                    if (this.checked) {
                        $(this).prop('checked', false)
                    } else {
                        $(this).prop('checked', true)
                    }
                }
            })
            $(document).on('change', '.user-verification-status', function (e) {
                if (confirm("Are you sure want to change verified status?")) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        url: "{{route('admin.users.changeVerificationStatus')}}",
                        type: 'POST',
                        data: {
                            id: $(this).attr('data-id'),
                            status: $(this).attr('data-status')
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $("#overlay").show();
                        },
                        success: function (res) {
                            if (res.response === "success") {
                                $.notify(res.message, 'success', 'top-right');

                            } else {

                                $.notify(res.message, 'error', 'top-right');
                            }
                        },
                        error: function (jqXhr) {

                            let data = jqXhr.responseJSON;
                            if (data.errors) {
                                let error = '';
                                $.each(data.errors, function (index, item) {
                                    error += item[0] + "\n";
                                });

                                $.notify(error, 'error', 'top-right');
                            }

                        },

                        complete: function () {
                            $("#overlay").hide();
                        }
                    });
                } else {
                    if (this.checked) {
                        $(this).prop('checked', false)
                    } else {
                        $(this).prop('checked', true)
                    }

                }
            })
        });

    </script>
@endsection
