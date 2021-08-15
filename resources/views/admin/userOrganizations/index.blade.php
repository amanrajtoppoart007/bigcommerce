@extends('layouts.admin')
@section('content')
@can('user_organization_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-organizations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userOrganization.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'UserOrganization', 'route' => 'admin.user-organizations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.userOrganization.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-UserOrganization">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.gst_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.representative_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.representative_designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.primary_contact') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.work_area') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.amount_deposited_method') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.amount_deposited') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_address_line_two') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_district') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_city') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_pincode') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.representative_address_line_two') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.representative_image') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.aadhaar_card') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.pan_card') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.organization_address_proof') }}
                    </th>
                    <th>
                        {{ trans('cruds.userOrganization.fields.signature') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($districts as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($cities as $key => $item)
                                <option value="{{ $item->city_name }}">{{ $item->city_name }}</option>
                            @endforeach
                        </select>
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
@can('user_organization_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-organizations.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
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
    ajax: "{{ route('admin.user-organizations.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'gst_number', name: 'gst_number' },
{ data: 'organization_name', name: 'organization_name' },
{ data: 'representative_name', name: 'representative_name' },
{ data: 'representative_designation', name: 'representative_designation' },
{ data: 'email', name: 'email' },
{ data: 'primary_contact', name: 'primary_contact' },
{ data: 'work_area', name: 'work_area' },
{ data: 'amount_deposited_method', name: 'amount_deposited_method' },
{ data: 'amount_deposited', name: 'amount_deposited' },
{ data: 'organization_address_line_two', name: 'organization_address_line_two' },
{ data: 'organization_district_name', name: 'organization_district.name' },
{ data: 'organization_city_city_name', name: 'organization_city.city_name' },
{ data: 'organization_pincode', name: 'organization_pincode' },
{ data: 'representative_address_line_two', name: 'representative_address_line_two' },
{ data: 'representative_image', name: 'representative_image', sortable: false, searchable: false },
{ data: 'aadhaar_card', name: 'aadhaar_card', sortable: false, searchable: false },
{ data: 'pan_card', name: 'pan_card', sortable: false, searchable: false },
{ data: 'organization_address_proof', name: 'organization_address_proof', sortable: false, searchable: false },
{ data: 'signature', name: 'signature', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-UserOrganization').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
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
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection