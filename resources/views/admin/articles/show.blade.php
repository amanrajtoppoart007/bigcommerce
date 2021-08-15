@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.article.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.articles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.id') }}
                        </th>
                        <td>
                            {{ $article->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.user') }}
                        </th>
                        <td>
                            {{ $article->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.title') }}
                        </th>
                        <td>
                            {{ $article->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.sub_title') }}
                        </th>
                        <td>
                            {{ $article->sub_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.category') }}
                        </th>
                        <td>
                            {{ App\Models\Article::CATEGORY_SELECT[$article->category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.tags') }}
                        </th>
                        <td>
                            @foreach($article->tags as $key => $tags)
                                <span class="label label-info">{{ $tags->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.primary_image') }}
                        </th>
                        <td>
                            @if($article->primary_image)
                                <a href="{{ $article->primary_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $article->primary_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.article.fields.content') }}
                        </th>
                        <td>
                            {!! $article->content !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.articles.index') }}">
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
            <a class="nav-link" href="#article_article_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.articleComment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#article_article_likes" role="tab" data-toggle="tab">
                {{ trans('cruds.articleLike.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="article_article_comments">
            @includeIf('admin.articles.relationships.articleArticleComments', ['articleComments' => $article->articleArticleComments])
        </div>
        <div class="tab-pane" role="tabpanel" id="article_article_likes">
            @includeIf('admin.articles.relationships.articleArticleLikes', ['articleLikes' => $article->articleArticleLikes])
        </div>
    </div>
</div>

@endsection