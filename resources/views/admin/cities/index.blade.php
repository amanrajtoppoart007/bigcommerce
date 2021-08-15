@extends('layouts.admin')
@section('content')
    @can('city_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <button class="btn btn-success" id="addButton">
                    {{ trans('global.add') }} {{ trans('cruds.city.title_singular') }}
                </button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'City', 'route' => 'admin.cities.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.city.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-City">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.city.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.city.fields.district') }}
                    </th>
                    <th>
                        {{ trans('cruds.city.fields.city_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.city.fields.status') }}
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($districts as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
    <div class="modal fade" id="addModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add/Edit City</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form id="cityForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required" for="district_id">{{ trans('cruds.city.fields.district') }}</label>
                            <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}"
                                    name="district_id" id="district_id" required>
                                @foreach($districts as $id => $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('district'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('district') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.city.fields.district_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city_name">{{ trans('cruds.city.fields.city_name') }}</label>
                            <input class="form-control {{ $errors->has('city_name') ? 'is-invalid' : '' }}" type="text"
                                   name="city_name" id="city_name" value="{{ old('city_name', '') }}" required>
                            @if($errors->has('city_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.city.fields.city_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                                       required {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                                <label class="required form-check-label"
                                       for="status">{{ trans('cruds.city.fields.status') }}</label>
                            </div>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.city.fields.status_helper') }}</span>
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
            @can('city_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.cities.massDestroy') }}",
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
                ajax: "{{ route('admin.cities.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'id', name: 'id'},
                    {data: 'district_name', name: 'district.name'},
                    {data: 'city_name', name: 'city_name'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 10,
            };
            let table = $('.datatable-City').DataTable(dtOverrideGlobals);
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

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let isUpdate = false;
            $('#addButton').click(() => {
                isUpdate = false;
                $('#cityForm').trigger('reset');
                $('#addModal').modal('show');
            });
            $('#cityForm').submit(function (event){
                event.preventDefault();
                let url = isUpdate ? "{{ route('admin.city.update') }}" : "{{ route("admin.city.add") }}";
                $.post(url, $(this).serialize(), result => {
                    alert(result.msg)
                    if(result.status){
                        location.reload()
                    }
                }, 'json');
            });

            $('.editButton').click(function (){
                let id = $(this).data('id');
                isUpdate = true;
                $.get("{{ route('admin.get.city') }}", {id}, result => {
                    if(result.status){
                        $('#city_name').val(result.data.city_name);
                        $('#id').val(result.data.id);
                        $('#district_id').val(result.data.district_id).trigger('change');
                        $('#addModal').modal('show');
                    }
                }, 'json');
            });
        });

    </script>
@endsection
