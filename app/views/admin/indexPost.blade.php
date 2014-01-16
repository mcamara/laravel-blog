@extends('layouts.admin')

@section('title')
	@parent
	:: Posts list
@stop

@section('styles')
	{{ HTML::style('css/datatables/dataTables.bootstrap.css') }}
@stop

@section('javascripts')
    {{ HTML::script('js/angularPagination.js') }}
@stop

@section('content')
	<h2>@lang('messages.posts_list')</h2>
	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-12 pull-right">
			<a href="{{route('createPost')}}" class="btn btn-primary btn-lg btn-block">
				@lang('messages.post_create')
			</a>
		</div>
	</div>
	<div class="row" ng-controller="postCtrl" data-ng-init="changePage(1)">
		<div class="row">
			<table id="postList" class="col-md-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th class="col-sm-8">@lang('messages.post_title')</th>
						<th class="col-sm-1">@lang('messages.post_views')</th>
						<th class="col-sm-3">@lang('messages.post_actions')</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="post in posts">
						<td><%post.title%></td>
						<td><%post.views%></td>
						<td>
							<a href="{{route('postList')}}/edit/<%post.id%>" class="btn btn-warning">Edit</a>
							<a href="{{route('postList')}}/delete/<%post.id%>" class="btn btn-danger">Delete</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-12">
				<ul class="pager">
					<li ng-if="current_page == 1" class="disabled">
						<a href="#" ng-click="previousPage()">@lang('pagination.previous')</a>
					</li>
					<li ng-if="current_page != 1">
						<a href="#" ng-click="previousPage()">@lang('pagination.previous')</a>
					</li>
					<li ng-if="current_page == last_page" class="disabled">
						<a href="#" ng-click="nextPage()">@lang('pagination.next')</a>
					</li>
					<li ng-if="current_page != last_page">
						<a href="#" ng-click="nextPage()">@lang('pagination.next')</a>
					</li>
				</ul>
				<div class="row">
					<div class="col-md-12">
						Showing <% per_page * (current_page-1) %> to <% per_page * (current_page) %> (<% total_posts %> posts in total)
					</div>
				</div>
			</div>
		</div>
	</div>

@stop
