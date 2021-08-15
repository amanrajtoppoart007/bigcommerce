@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pincode.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pincodes.update", [$pincode->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="pincode">{{ trans('cruds.pincode.fields.pincode') }}</label>
                <input class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" type="text" name="pincode" id="pincode" value="{{ old('pincode', $pincode->pincode) }}" required>
                @if($errors->has('pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pincode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pincode.fields.pincode_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $pincode->status || old('status', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.pincode.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pincode.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="block_id">{{ trans('cruds.pincode.fields.block') }}</label>
                <select class="form-control select2 {{ $errors->has('block_id') ? 'is-invalid' : '' }}" name="block_id" id="block_id" required>
                    @foreach($blocks as $id => $block)
                        <option value="{{ $id }}" {{ (old('block_id') ? old('block_id') : $pincode->block->id ?? '') == $id ? 'selected' : '' }}>{{ $block }}</option>
                    @endforeach
                </select>
                @if($errors->has('block_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('block_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pincode.fields.block_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
