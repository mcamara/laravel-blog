@extends('layouts.master')

@section('content')
	<div class="container clearfix">
		<div class="row" id="blog_body">
			{{-- This section would be on the right in a screen >= md and would be the first one otherwise --}}
			<aside id="right_bar" class="col-md-3 col-sm-12 col-xs-12 col-xs-pull-12 pull-right">
				@include('partials/rightBar')
			</aside>
			{{-- This section would be on the left in a screen >= md and down otherwise --}}
			<div id="left_bar" class="col-md-9 col-sm-12 col-xs-12 col-xs-push-12 pull-left" role="main">
      			@yield('blog_content')
			</div>
		</div>
	</div>
@stop