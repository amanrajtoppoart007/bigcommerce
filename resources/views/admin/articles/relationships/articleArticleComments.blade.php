@can('article_comment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.article-comments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.articleComment.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.articleComment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-articleArticleComments">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.articleComment.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.articleComment.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.articleComment.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.articleComment.fields.article') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articleComments as $key => $articleComment)
                        <tr data-entry-id="{{ $articleComment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $articleComment->id ?? '' }}
                            </td>
                            <td>
                                {{ $articleComment->user->name ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $articleComment->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $articleComment->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $articleComment->article->title ?? '' }}
                            </td>
                            <td>
                                @can('article_comment_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.article-comments.show', $articleComment->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('article_comment_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.article-comments.edit', $articleComment->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('article_comment_delete')
                                    <form action="{{ route('admin.article-comments.destroy', $articleComment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('article_comment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.article-comments.massDestroy') }}",
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
  let table = $('.datatable-articleArticleComments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection