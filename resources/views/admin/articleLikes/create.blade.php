@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.articleLike.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.article-likes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.articleLike.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleLike.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="article_id">{{ trans('cruds.articleLike.fields.article') }}</label>
                <select class="form-control select2 {{ $errors->has('article') ? 'is-invalid' : '' }}" name="article_id" id="article_id" required>
                    @foreach($articles as $id => $article)
                        <option value="{{ $id }}" {{ old('article_id') == $id ? 'selected' : '' }}>{{ $article }}</option>
                    @endforeach
                </select>
                @if($errors->has('article'))
                    <div class="invalid-feedback">
                        {{ $errors->first('article') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleLike.fields.article_helper') }}</span>
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