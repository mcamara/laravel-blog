@extends('layouts.blog')

@section('title')
	@parent
	:: Home
@stop

@section('javascripts')
	<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		var disqus_shortname = 'marccamara'; // required: replace example with your forum shortname
		var disqusPublicKey = "ggV8HawSyPuTW1cP6fqP1VM0DYdiYPu1wLuGhlijcyjY4NxEVmWhDpMvWLwvASeQ";
		var identifierArray = [];
		$('.count-comments').each(function () {
		  	var identifier = $(this).attr('data-disqus-identifier');
		  	identifierArray.push('ident:' + identifier);
		});
		$(function() {
		  	$.ajax({
			    type: 'GET',
			    url: "https://disqus.com/api/3.0/threads/set.jsonp",
			    data: { api_key: disqusPublicKey, forum : disqus_shortname, thread : identifierArray },
			    cache: false,
			    dataType: 'jsonp',
			    success: function (result) {
					for (var i in result.response) {
						var countText = " @lang('messages.comments')";
						var count = result.response[i].posts;

						if (count == 1)
							countText = " @lang('messages.comment')";

						$('span[data-disqus-identifier="' + result.response[i].identifiers[0] + '"]').html(count);
					}
			    }
		  	});
		});
	</script>
@stop

@section('blog_content')
	<section class="post-container">
		@foreach($posts as $post)
			<article class="single-post">
				@include('partials/postInfo', ['post'=>$post, 'linkable' => true, 'comment_counter' => true])
				<div class="container post-content">
					<div class="row">
						<div class="col-md-12">
							@if(!in_array($locale, $post->translations))
								<span class="not-languaged">@lang('messages.not_languaged')</span>
							@endif
							{{$post->excerpt}}
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 read-more">
							<a href="{{route('viewPost',['slug'=>$post->slug])}}" class="btn btn-primary">
								@lang('messages.post_read_more')   <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
				</div>
			</article>
		@endforeach
	</section>
	<div class="container paginator-container">
		{{$posts->links()}}
	</div>
@stop