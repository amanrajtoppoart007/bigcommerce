@can('user_organization_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-organizations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userOrganization.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.userOrganization.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userUserOrganizations">
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
                </thead>
                <tbody>
                    @foreach($userOrganizations as $key => $userOrganization)
                        <tr data-entry-id="{{ $userOrganization->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $userOrganization->id ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->gst_number ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->organization_name ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->representative_name ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->representative_designation ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->email ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->primary_contact ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->work_area ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->amount_deposited_method ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->amount_deposited ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->organization_address_line_two ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->organization_district->name ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->organization_city->city_name ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->organization_pincode ?? '' }}
                            </td>
                            <td>
                                {{ $userOrganization->representative_address_line_two ?? '' }}
                            </td>
                            <td>
                                @if($userOrganization->representative_image)
                                    <a href="{{ $userOrganization->representative_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $userOrganization->representative_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($userOrganization->aadhaar_card)
                                    <a href="{{ $userOrganization->aadhaar_card->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($userOrganization->pan_card)
                                    <a href="{{ $userOrganization->pan_card->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($userOrganization->organization_address_proof)
                                    <a href="{{ $userOrganization->organization_address_proof->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($userOrganization->signature)
                                    <a href="{{ $userOrganization->signature->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $userOrganization->signature->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('user_organization_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-organizations.show', $userOrganization->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_organization_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-organizations.edit', $userOrganization->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_organization_delete')
                                    <form action="{{ route('admin.user-organizations.destroy', $userOrganization->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_organization_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-organizations.massDestroy') }}",
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
  let table = $('.datatable-userUserOrganizations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection