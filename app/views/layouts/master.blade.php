<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/ico">
		<meta name="title" content="Marc Camara - Software developer" /> 
		<meta name="description" content="Marc Camara - Software Developer" /> 
		<meta name="keywords" content="@foreach($categories as $cat){{$cat->name_en}}, @endforeach" /> 
		<meta property="og:title" content="Marc Camara - Software developer"/> 
		<meta property="og:type" content="company"/> 
		<meta property="og:site_name" content="Marc Camara - Software developer"/> 
		<meta property="og:description" content="This is the personal website of Marc Camara, software developer" />
		<meta property="og:url" content="{{url()}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>
			@section('title')
			Marc C&aacute;mara
			@show
		</title>

		<!-- CSS are placed here -->
		{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css') }}
		{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') }}
		{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.css') }}
		{{ HTML::style('//fonts.googleapis.com/css?family=Alegreya+Sans:400,700') }}
		{{ HTML::style('css/styles.css') }}
	    @section('styles')
	    @show

	</head>
	<body>
		<div id="wrap">
			<div class="container">
			    <div class="row">
			    	{{Notification::showAll()}}
		    	</div>
		    </div>
			<div id="content">
				<div class="container"> 
	      			@yield('content')
	      		</div>
      		</div>
      	</div>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12 first hidden-xs hidden-sm">
						<a class="twitter-timeline" href="https://twitter.com/marc_camara" data-widget-id="421509365414105088">Tweets by @marc_camara</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 second">
						<div class="done">
							<div class="done_images">
								<img src="{{url('images/logos/laravel.png')}}" alt="laravel"/>
							</div>
							@lang('messages.done_with_laravel')
						</div>
						<div class="blog-laravel">
							@lang('messages.page_in_github')
							<a href="https://github.com/mcamara/laravel-4-blog" target="_blank">
								<i class="fa fa-github"></i>
							</a>
						</div>
						<div class="row change-language">
							<div class="col-xs-12">
								{{ LaravelLocalization::getLanguageBar(false) }}
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 third hidden-xs">
						<h3>Marc C&aacute;mara</h3>
						<ul class="contact">
							<li>
								<a href="mailto:marc.camara.garcia@gmail.com" target="_top">
									<i class="fa fa-envelope"></i> marc.camara.garcia@gmail.com
								</a>
							</li>
							<li>
								<a href="http://www.linkedin.com/profile/view?id=59817942" target="_blank">
									<i class="fa fa-linkedin-square"></i> Marc C&aacute;mara
								</a>
							</li>
							<li>
								<a href="https://github.com/mcamara" target="_blank">
									<i class="fa fa-github-square"></i> mcamara
								</a>
							</li>
							<li>
								<a href="https://twitter.com/marc_camara" target="_blank">
									<i class="fa fa-twitter-square"></i> @marc_camara
								</a>
							</li>
							<li>
								<a href="https://plus.google.com/+MarcCámaraGarcia/posts" target="_blank">
									<i class="fa fa-google-plus-square"></i> +MarcCamaraGarcia
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</body>

    <!-- Scripts are placed here -->
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
    {{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
    @section('javascripts')
    @show

</html>