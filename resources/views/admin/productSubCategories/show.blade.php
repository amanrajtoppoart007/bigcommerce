@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productSubCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-sub-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.productSubCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $productSubCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productSubCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $productSubCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productSubCategory.fields.category') }}
                        </th>
                        <td>
                            {{ $productSubCategory->category->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productSubCategory.fields.description') }}
                        </th>
                        <td>
                            {{ $productSubCategory->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.photo') }}
                        </th>
                        <td>
                            @if($productSubCategory->photo)
                                <a href="{{ $productSubCategory->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $productSubCategory->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-sub-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
