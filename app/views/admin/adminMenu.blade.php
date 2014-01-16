@extends('layouts.admin')

@section('title')
	@parent
	:: Login
@stop

@section('styles')
@stop

@section('content')
	Hola {{$user->first_name}}
	<a href="{{route('createPost')}}">Create post</a>
@stop
