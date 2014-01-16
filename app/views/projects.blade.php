@extends('layouts.blog')

@section('title')
	@parent
	:: Home
@stop

@section('styles')
@stop

@section('javascripts')
	<script type="text/javascript">
		$('.carousel').carousel({
		  	interval: 5000
		});
	</script>
@stop

@section('blog_content')
	<div class="project-container container">
		<div class="col-md-12">
			<h2>@lang('messages.recent_work')</h2>
		</div>
		<div class="project row">
			<div class="col-md-12">
				<h3>
					Miosports 
					<a href="http://www.miosports.com" target="_blank">
						<i class="fa fa-info-circle pull-right"></i>
					</a>
				</h3>
			</div>
			<div id="carousel-miosports" class="carousel slide col-md-6 col-sm-6 col-xs-12" data-ride="carousel">
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="{{url('images/projects/miosports/miosports1.png')}}">
					</div>
					<div class="item">
						<img src="{{url('images/projects/miosports/miosports2.png')}}">
					</div>
					<div class="item">
						<img src="{{url('images/projects/miosports/miosports3.png')}}">
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-miosports" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-miosports" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 description">
				<p>@lang('messages.miosports_description')</p>
				<div class="technologies">
					<img src="{{url('images/logos/laravel.png')}}" alt="laravel" class="grayscale"/>
					<img src="{{url('images/logos/angular.png')}}" alt="angular" class="grayscale"/>
					<img src="{{url('images/logos/mongo.png')}}" alt="mongo" class="grayscale"/>
				</div>
			</div>
		</div>
		<div class="project row">
			<div class="col-md-12">
				<h3>
					Pickbe 
					<a href="http://mobileworldcapital.com/en/article/48" target="_blank">
						<i class="fa fa-info-circle pull-right"></i>
					</a>
				</h3>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 description">
				<p>@lang('messages.pickbe_description')</p>
				<div class="technologies">
					<img src="{{url('images/logos/codeigniter.png')}}" alt="codeigniter" class="grayscale"/>
					<img src="{{url('images/logos/magento.png')}}" alt="magento" class="grayscale"/>
					<img src="{{url('images/logos/html5.png')}}" alt="html5" class="grayscale"/>
				</div>
			</div>
			<div id="carousel-pickbe" class="carousel slide col-md-6 col-sm-6 col-xs-12" data-ride="carousel">
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			    <div class="item active">
			      	<img src="{{url('images/projects/pickbe/pickbe1.png')}}">
			    </div>
			    <div class="item">
			      	<img src="{{url('images/projects/pickbe/pickbe2.png')}}">
			    </div>
			    <div class="item">
			      	<img src="{{url('images/projects/pickbe/pickbe3.png')}}">
			    </div>
			    <div class="item">
			      	<img src="{{url('images/projects/pickbe/pickbe4.png')}}">
			    </div>
			    <div class="item">
			      	<img src="{{url('images/projects/pickbe/pickbe5.png')}}">
			    </div>
			  </div>
			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-pickbe" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left"></span>
			  </a>
			  <a class="right carousel-control" href="#carousel-pickbe" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right"></span>
			  </a>
			</div>
		</div>
		<div class="project row">
			<div class="col-md-12">
				<h3>Laravel Localization 
					<a href="https://github.com/mcamara/laravel-localization" target="_blank">
						<i class="fa fa-github pull-right"></i>
					</a>
					<a href="https://packagist.org/packages/mcamara/laravel-localization" target="_blank">
						<i class="fa fa-info-circle pull-right"></i>
					</a>
				</h3>
			</div>
			<div id="carousel-localization" class="carousel slide col-md-6 col-sm-6 col-xs-12" data-ride="carousel">
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="{{url('images/projects/localization/localization.png')}}">
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 description">
				<p>@lang('messages.laravel_loc_description')</p>
				<div class="technologies">
					<img src="{{url('images/logos/laravel.png')}}" alt="laravel" class="grayscale"/>
				</div>
			</div>
		</div>
		<div class="project row">
			<div class="col-md-12">
				<h3>Sailing Technologies 
					<a href="http://sailingtechnologies.com" target="_blank">
						<i class="fa fa-info-circle pull-right"></i>
					</a>
				</h3>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 description">
				<p>@lang('messages.sailing_description')</p>
				<div class="technologies">
					<img src="{{url('images/logos/wordpress.png')}}" alt="wordpress" class="grayscale"/>
				</div>
			</div>
			<div id="carousel-sailing" class="carousel slide col-md-6 col-sm-6 col-xs-12" data-ride="carousel">
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="{{url('images/projects/sailing/sailing1.png')}}">
					</div>
					<div class="item">
						<img src="{{url('images/projects/sailing/sailing2.png')}}">
					</div>
					<div class="item">
						<img src="{{url('images/projects/sailing/sailing3.png')}}">
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-sailing" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-sailing" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>
		<div class="more_projects row">
			<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
				<p>@lang('messages.more_projects')</p>
			</div>
		</div>
	</div>
@stop