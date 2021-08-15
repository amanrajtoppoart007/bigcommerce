<div class="card">
    <div class="card-header">
        {{ trans('cruds.productUnit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-articleArticleComments">
                <thead>
                <tr>
                    <th>
                        {{ trans('cruds.productUnit.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.unit_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.purchase_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.bulk_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.discount') }}
                    </th>
                    <th>
                        {{ trans('cruds.productUnit.fields.bulk_discount') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($productUnits as $key => $productUnit)
                    <tr data-entry-id="{{ $productUnit->id }}">
                        <td>
                            {{ $productUnit->id ?? '' }}
                        </td>
                        <td>
                            {{ $productUnit->unit ?? '' }}
                        </td>
                        <td>
                            {{ $productUnit->quantity ?? '' }}
                        </td>
                        <td>
                            {{ $productUnit->purchase_price ?? '' }}
                        </td><td>
                            {{ $productUnit->price ?? '' }}
                        </td><td>
                            {{ $productUnit->bulk_price ?? '' }}
                        </td><td>
                            {{ $productUnit->discount ?? '' }}
                        </td><td>
                            {{ $productUnit->bulk_discount ?? '' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
