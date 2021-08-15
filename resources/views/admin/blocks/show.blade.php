@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.block.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.id') }}
                        </th>
                        <td>
                            {{ $block->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.name') }}
                        </th>
                        <td>
                            {{ $block->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.district') }}
                        </th>
                        <td>
                            {{ $block->district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $block->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#block_pincodes" role="tab" data-toggle="tab">
                {{ trans('cruds.pincode.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="block_pincodes">
            @includeIf('admin.blocks.relationships.blockPincodes', ['pincodes' => $block->blockPincodes])
        </div>
    </div>
</div>

@endsection