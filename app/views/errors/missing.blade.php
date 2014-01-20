@extends('layouts.blog')

@section('blog_content')
	<section class="error-container container">
		<div class="row">
			<div class="col-xs-12">
				<h3>@lang('messages.page_not_found')</h3>
				<h4>@lang('messages.404')</h4>
			</div>
		</div>
		<div class="row">
			<div class="image-404 col-xs-12">
				<img src="{{url('images/crab.gif')}}" alt="404 crab">
			</div>
		</div>
		<div class="row text-404">
			<div class="col-xs-12">
				@lang('messages.crab_404_1')
			</div>
			<div class="col-xs-12">
				@lang('messages.crab_404_2')
			</div>
		</div>
	</section>
@stop