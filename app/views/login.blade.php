@extends('layouts.master')

@section('title')
	@parent
	:: Login
@stop

@section('styles')
    <style type="text/css">
	    .form-signin {
	    	max-width: 330px;
	    	padding: 15px;
	    	margin: 0 auto;
	    }
    </style>
@stop

@section('content')
	{{ Form::open(['url' => route('LoginPost'),'class'=>'form-signin']) }}
		<h2 class="form-signin-heading">Please sign in</h2>
		{{Form::email("email","",['class'=>"form-control","placeholder"=>"Email Address"])}}
		{{Form::password("password",['class'=>"form-control","placeholder"=>"Password"])}}
		<label class="checkbox">
			{{Form::checkbox('remember', '1')}} Remember
		</label>
		{{Form::submit('Sign in!',["class"=>"btn btn-lg btn-primary btn-block"])}}
		{{Form::token()}}
	{{ Form::close() }}
@stop
