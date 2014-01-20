@extends('layouts.blog')

@section('title')
	@parent
	:: Login
@stop

@section('styles')
@stop

@section('blog_content')
	<section class="login-container container">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
				<h2 class="text-center login-title">Please sign in</h2>
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                    alt="">
				{{ Form::open(['url' => route('LoginPost'),'class'=>'form-signin']) }}
					{{Form::email("email","",['class'=>"form-control","placeholder"=>"Email Address"])}}
					{{Form::password("password",['class'=>"form-control","placeholder"=>"Password"])}}
					<label class="checkbox">
						{{Form::checkbox('remember', '1')}} Remember
					</label>
					{{Form::submit('Sign in!',["class"=>"btn btn-lg btn-primary btn-block"])}}
					{{Form::token()}}
				{{ Form::close() }}
            </div>
        </div>
	</section>
@stop
