<!DOCTYPE html>
<html ng-app="app">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/ico">
		<title>
			@section('title')
			Blog
			@show
		</title>

		<!-- CSS are placed here -->
		{{ HTML::style('https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css') }}
		{{ HTML::style('https://netdna.bootstrapcdn.com/bootswatch/3.0.2/yeti/bootstrap.min.css') }}
		{{ HTML::style('https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css') }}
	    @section('styles')
	    @show

	</head>
	<body>
		<div class="navbar navbar-default">
            <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{route('adminMenu')}}">Administration</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							@lang('messages.posts') <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{route('postList')}}">@lang('messages.posts_list')</a></li>
							<li><a href="{{route('categoryList')}}">@lang('messages.categories')</a></li>
							<li><a href="{{route('createPost')}}">@lang('messages.post_create')</a></li>
						</ul>
					</li>
				</ul>
            </div><!-- /.nav-collapse -->
          </div>
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
	</body>

    <!-- Scripts are placed here -->
    {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
    {{ HTML::script('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular-resource.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular-sanitize.js') }}
    <script type="text/javascript">
      	var app = angular.module("app", ['ngResource','ngSanitize']);
		app.config(
			function($interpolateProvider){
				$interpolateProvider.startSymbol('<%').endSymbol('%>');
			}
		);
    </script>

    @section('javascripts')
    @show

</html>