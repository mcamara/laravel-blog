@extends('layouts.admin')

@section('title')
	@parent
	:: Edit Post
@stop

@section('styles')
	{{ HTML::style('css/typeahead.css') }}
	{{ HTML::style('css/bootstrap-tagsinput.css') }}
@stop

@section('javascripts')
    {{ HTML::script('js/ckeditor/ckeditor.js') }}
	<script>
	    CKEDITOR.replaceClass = 'ckeditable' ;
	</script>

    {{ HTML::script('js/typeahead.min.js') }}
    {{ HTML::script('js/bootstrap-tagsinput.min.js') }}

	<script type="text/javascript">
		var tags = $(".typeahead");
	    tags.tagsinput();

	    tags.tagsinput('input').typeahead({
		  	name: 'categories',
		  	limit: 15,
		  	local: [
		  		@foreach($categories as $category)
		  			"{{$category->name_en}}",
		  		@endforeach
		  	]
	    }).bind('typeahead:selected', $.proxy(function (obj, datum) {
	      tags.tagsinput('add', datum.value);
	      tags.tagsinput('input').typeahead('setQuery', '');
	    }, $('input')));
	    //https://github.com/TimSchlechter/bootstrap-tagsinput/issues/52
	    //http://welldonethings.com/tags/manager/v3
	</script>
@stop

@section('content')
	<h2>@lang('messages.post_create')</h2>

	{{ Form::model($post,['url' => route('updatePost',['id'=>$post->id]),'files' => true ,'class'=>'form-horizontal']) }}
		<div id="languageInfo" class="col-md-12">
			<ul id="languagesTabs" class="nav nav-pills">
				<?php $index = 0 ?>
				@foreach($languages as $abbrlang => $lang)
					@if($index == 0)
						<li class="active">
						<?php $index++ ?>
					@else
						<li>
					@endif
					<a href="#{{$abbrlang}}_panel" data-toggle="tab">{{$lang}}</a></li>
				@endforeach
			</ul>
			<div id='content' class="tab-content">
				<?php $index = 0 ?>
				@foreach($languages as $abbrlang => $lang)
					@if($index == 0)
						<div class="tab-pane active" id="{{$abbrlang}}_panel">
						<?php $index++ ?>
					@else
						<div class="tab-pane" id="{{$abbrlang}}_panel">
					@endif
						<div class="form-group">
						  	<label for="title_{{$abbrlang}}" class="col-md-2 col-sm-3 col-xs-6 control-label">@lang('messages.post_title')</label>
						  	<div class="col-md-6 col-sm-9 col-xs-12">
								{{ Form::text("title_".$abbrlang,$post->{"title_$abbrlang"},['class'=>"form-control","placeholder"=>Lang::get('messages.title')]) }}
						  	</div>
						</div>
						<div class="form-group">
						  	<label for="content_{{$lang}}" class="col-md-2 col-sm-3 col-xs-6 control-label">@lang('messages.post_content')</label>
						  	<div class="col-md-9 col-sm-9 col-xs-12">
								{{ Form::textarea("content_".$abbrlang,$post->{"content_$abbrlang"},['class'=>"form-control ckeditable"]) }}
						  	</div>
						</div>
					</div>
				@endforeach
				<div class="form-group">
				  	<label for="title_{{$lang}}" class="col-md-2 col-sm-3 col-xs-6 control-label">@lang('messages.categories')</label>
				  	<div class="col-md-6 col-sm-9 col-xs-12">
				  		<?php 
				  			$categories = array();
				  			foreach($post->categories as $category):
				  				$categories[] = $category->name_en;
				  			endforeach
				  		?>
						{{ Form::text("categories",implode(",",$categories),['id' => "id_typeahead",'class'=>"typeahead","placeholder"=>Lang::get('messages.categories')]) }}
				  	</div>
				</div>
				@if(!is_null($post->image))
					<div class="form-group">
						<label for="image" class="col-md-2 col-sm-3 col-xs-6 control-label">@lang('messages.post_image')</label>
					  	<div class="col-md-9 col-sm-9 col-xs-12">
							<img src="{{url($post->image)}}" class="img-responsive"/>
					  	</div>
					</div>
				@endif
				<div class="form-group">
					<label for="image" class="col-md-2 col-sm-3 col-xs-6 control-label">@lang('messages.post_image_change')</label>
				  	<div class="col-md-6 col-sm-9 col-xs-12">
						{{Form::file('image')}}
					</div>
				</div>
			</div>
		</div>
		{{ Form::submit(Lang::get('messages.post_edit'),["class"=>"btn btn-lg btn-primary"]) }}
		{{ Form::token() }}
	{{ Form::close() }}
@stop
