<div class="card">
    <div class="card-header">
        {{ trans('cruds.productPrice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-articleArticleComments">
                <thead>
                <tr>
                    <th>
                        {{ trans('cruds.productPrice.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.unit_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.purchase_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.bulk_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.discount') }}
                    </th>
                    <th>
                        {{ trans('cruds.productPrice.fields.bulk_discount') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($productPrices as $key => $productPrice)
                    <tr data-entry-id="{{ $productPrice->id }}">
                        <td>
                            {{ $productPrice->id ?? '' }}
                        </td>
                        <td>
                            {{ $productPrice->unit ?? '' }}
                        </td>
                        <td>
                            {{ $productPrice->quantity ?? '' }}
                        </td>
                        <td>
                            {{ $productPrice->purchase_price ?? '' }}
                        </td><td>
                            {{ $productPrice->price ?? '' }}
                        </td><td>
                            {{ $productPrice->bulk_price ?? '' }}
                        </td><td>
                            {{ $productPrice->discount ?? '' }}
                        </td><td>
                            {{ $productPrice->bulk_discount ?? '' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
