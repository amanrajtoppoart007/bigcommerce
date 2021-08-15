@extends('layouts.admin')
@section('content')
    @can('user_alert_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <button class="btn btn-success" id="addButton">
                    {{ trans('global.add') }} {{ trans('cruds.userAlert.title_singular') }}
                </button>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userAlert.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-UserAlert">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.alert_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.alert_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.created_at') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add/Edit User Alert</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form id="userAlertForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required"
                                   for="alert_text">{{ trans('cruds.userAlert.fields.alert_text') }}</label>
                            <input class="form-control {{ $errors->has('alert_text') ? 'is-invalid' : '' }}" type="text"
                                   name="alert_text" id="alert_text" value="{{ old('alert_text', '') }}" required>
                            @if($errors->has('alert_text'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('alert_text') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAlert.fields.alert_text_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="alert_link">{{ trans('cruds.userAlert.fields.alert_link') }}</label>
                            <input class="form-control {{ $errors->has('alert_link') ? 'is-invalid' : '' }}" type="text"
                                   name="alert_link" id="alert_link" value="{{ old('alert_link', '') }}">
                            @if($errors->has('alert_link'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('alert_link') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAlert.fields.alert_link_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="users">{{ trans('cruds.userAlert.fields.user') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all"
                                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all"
                                      style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}"
                                    name="users[]" id="users" multiple>
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}">{{ $user }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('users'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('users') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAlert.fields.user_helper') }}</span>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_alert_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.user-alerts.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
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
                ajax: "{{ route('admin.user-alerts.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'id', name: 'id'},
                    {data: 'alert_text', name: 'alert_text'},
                    {data: 'alert_link', name: 'alert_link'},
                    {data: 'user', name: 'users.name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 10,
            };
            let table = $('.datatable-UserAlert').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let isUpdate = false;
            $('#addButton').click(() => {
                isUpdate = false;
                $('#userAlertForm').trigger('reset');
                $('#addModal').modal('show');
            });
            $('#userAlertForm').submit(function (event) {
                event.preventDefault();
                let url = isUpdate ? "{{ route('admin.user-alert.update') }}" : "{{ route("admin.user-alert.add") }}";
                $.post(url, $(this).serialize(), result => {
                    alert(result.msg)
                    if (result.status) {
                        location.reload()
                    }
                }, 'json');
            });

            $('.editButton').click(function () {
                let id = $(this).data('id');
                isUpdate = true;
                $.get("{{ route('admin.get.user-alert') }}", {id}, result => {
                    if (result.status) {
                        $('#alert_text').val(result.data.alert_text);
                        $('#id').val(result.data.id);
                        $('#addModal').modal('show');
                    }
                }, 'json');
            });

        });

    </script>
@endsection
