@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
        <div class="float-right">
            <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            @if($user->kisanCards->count())
                <a class="btn btn-default" target="_blank" href="{{ route('admin.users.print.kisan-card', $user) }}">
                    {{ trans('global.print_kisan_card') }}
                </a>
            @endif
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.mobile') }}
                        </th>
                        <td>
                            {{ $user->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.help_center') }}
                        </th>
                        <td>
                            {{ $user->help_center->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.referral_code') }}
                        </th>
                        <td>
                            {{ $user->referral_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#user_orders" role="tab" data-toggle="tab">
                {{ trans('cruds.order.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#user_articles" role="tab" data-toggle="tab">
                {{ trans('cruds.article.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#user_article_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.articleComment.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#user_followers" role="tab" data-toggle="tab">
                {{ trans('cruds.follower.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#follow_followers" role="tab" data-toggle="tab">
                {{ trans('cruds.follower.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#user_article_likes" role="tab" data-toggle="tab">
                {{ trans('cruds.articleLike.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_transactions" role="tab" data-toggle="tab">
                {{ trans('cruds.transaction.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.userAddress.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_profiles" role="tab" data-toggle="tab">
                {{ trans('cruds.userProfile.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                {{ trans('cruds.userAlert.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="user_orders">
            @includeIf('admin.users.relationships.userOrders', ['orders' => $user->userOrders])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="user_articles">
            @includeIf('admin.users.relationships.userArticles', ['articles' => $user->userArticles])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="user_article_comments">
            @includeIf('admin.users.relationships.userArticleComments', ['articleComments' => $user->userArticleComments])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="user_followers">
            @includeIf('admin.users.relationships.userFollowers', ['followers' => $user->userFollowers])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="follow_followers">
            @includeIf('admin.users.relationships.followFollowers', ['followers' => $user->followFollowers])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="user_article_likes">
            @includeIf('admin.users.relationships.userArticleLikes', ['articleLikes' => $user->userArticleLikes])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_transactions">
            @includeIf('admin.users.relationships.userTransactions', ['transactions' => $user->userTransactions])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_addresses">
            @includeIf('admin.users.relationships.userUserAddresses', ['userAddresses' => $user->userUserAddresses])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_profiles">
            @includeIf('admin.users.relationships.userUserProfile', ['userProfile' => $user->userUserProfile])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="user_user_alerts">
            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
        </div>
    </div>
</div>

@endsection
