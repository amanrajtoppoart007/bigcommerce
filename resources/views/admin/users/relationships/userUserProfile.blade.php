@can('user_profile_create')
    <div style="margin-bottom: 10px;" class="row d-none">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-profiles.create', ['user_id' => $user->id]) }}">
                {{ trans('global.add') }} {{ trans('cruds.userProfile.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.userProfile.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userUserProfile">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.secondary_mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.farming_land_area') }}
                        </th>
                        <th>
                            {{ trans('cruds.userProfile.fields.image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                @if($userProfile)
                        <tr data-entry-id="{{ $userProfile->id ?? "" }}">
                            <td>

                            </td>
                            <td>
                                {{ $userProfile->id ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->name ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->email ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->secondary_mobile ?? '' }}
                            </td>
                            <td>
                                {{ $userProfile->farming_land_area ?? '' }}
                            </td>
                            <td>
                                @if($userProfile->image ?? '')
                                    <a href="{{ $userProfile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $userProfile->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('user_profile_show')
                                    <a class="btn btn-xs btn-primary d-none" href="{{ route('admin.user-profiles.show', $userProfile->id ?? '') }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_profile_edit')
                                    <a class="btn btn-xs btn-info d-none" href="{{ route('admin.user-profiles.edit', $userProfile->id ?? '') }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_profile_delete')
                                    <form class="d-none" action="{{ route('admin.user-profiles.destroy', $userProfile->id ?? '') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                @endif
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
@can('user_profile_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-profiles.massDestroy') }}",
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
  // dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-userUserProfile:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
