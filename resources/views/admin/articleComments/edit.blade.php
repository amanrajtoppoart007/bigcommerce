@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.articleComment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.article-comments.update", [$articleComment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.articleComment.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $articleComment->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleComment.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="comment">{{ trans('cruds.articleComment.fields.comment') }}</label>
                <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment" required>{{ old('comment', $articleComment->comment) }}</textarea>
                @if($errors->has('comment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleComment.fields.comment_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $articleComment->status || old('status', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="status">{{ trans('cruds.articleComment.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleComment.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="article_id">{{ trans('cruds.articleComment.fields.article') }}</label>
                <select class="form-control select2 {{ $errors->has('article') ? 'is-invalid' : '' }}" name="article_id" id="article_id" required>
                    @foreach($articles as $id => $article)
                        <option value="{{ $id }}" {{ (old('article_id') ? old('article_id') : $articleComment->article->id ?? '') == $id ? 'selected' : '' }}>{{ $article }}</option>
                    @endforeach
                </select>
                @if($errors->has('article'))
                    <div class="invalid-feedback">
                        {{ $errors->first('article') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.articleComment.fields.article_helper') }}</span>
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