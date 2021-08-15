@can('user_address_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-addresses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userAddress.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.userAddress.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userUserAddresses">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.state') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.district') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.block') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.pincode') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.area') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.village') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.userAddress.fields.address_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userAddresses as $key => $userAddress)
                        <tr data-entry-id="{{ $userAddress->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $userAddress->id ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->state->name ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->district->name ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->block->name ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->addressPincode->pincode ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->area->area ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->village ?? '' }}
                            </td>
                            <td>
                                {{ $userAddress->address ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\UserAddress::ADDRESS_TYPE_RADIO[$userAddress->address_type] ?? '' }}
                            </td>
                            <td>
                                @can('user_address_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-addresses.show', $userAddress->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_address_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-addresses.edit', $userAddress->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_address_delete')
                                    <form action="{{ route('admin.user-addresses.destroy', $userAddress->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_address_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-addresses.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-userUserAddresses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
