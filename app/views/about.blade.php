@extends('layouts.blog')

@section('title')
	@parent
	:: @lang('messages.about')
@stop

@section('styles')
@stop

@section('javascripts')
@stop

@section('blog_content')
	<div class="about-container">
		<div class="container">
			<div class="col-xs-12">
				<h2>@lang('messages.about_me')</h2>
			</div>
		</div>
		<img src="{{url('images/about.jpg')}}" class="img-responsive about-image" alt="About">
		<div class="container about-text">
			<div class="col-xs-12">
				@lang('messages.about_me_text')
			</div>
			<div class="col-xs-12 resume">
				<h3>@lang('messages.other_links')</h3>
				<a href="{{url('downloads/resume.pdf')}}" target="_blank">
					<img src="{{url('images/logos/pdf.png')}}" alt="resume"/>@lang('messages.resume')
				</a>
			</div>

		</div>
	</div>
@stop