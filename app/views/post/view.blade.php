@extends('layouts.blog')

@section('title')
	@parent
	:: {{$post->title}}
@stop
@section('javascripts')
	@include('partials/disqusComments')
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=385534638197852";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
	</script>
@stop

@section('blog_content')
	<div class="post-container">
		<article class="single-post">
			@include('partials/postInfo', ['post'=>$post, 'linkable' => false, 'comment_counter' => false])
			<div class="container post-content">
				<div class="row">
					<div class="col-md-12">
						@if(!in_array($locale, $post->translations))
							<span class="not-languaged">@lang('messages.not_languaged')</span>
						@endif
						{{$post->content}}
						<div class="row">
							<div class="col-md-12 social-buttons">
								<div class="fb-share-button" data-href="{{Request::url()}}" data-type="button_count"></div>
								<a href="https://twitter.com/share" class="twitter-share-button" 
									data-lang="{{Config::get('app.locale')}}" 
									data-text="{{(strlen($post->title) > 123) ? substr($post->title,0,120).'...' : $post->title}} - Marc Cámara Website">
										Tweet
								</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
								<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
								<script type="IN/Share" data-counter="right"></script>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container links">
				<div class="row">
					<div class="col-md-6 col-sm-12 next-link pull-left">
						@if(!is_null($next))
							<span>@lang('messages.post_next')</span><br/>
							<a href="{{route('viewPost',['slug'=>$next->slug])}}">
								{{$next->title}}
							</a>
						@endif
					</div>
					<div class="col-md-6 col-sm-12 prev-link pull-right">
						@if(!is_null($prev))
							<span>@lang('messages.post_prev')</span><br/>
							<a href="{{route('viewPost',['slug'=>$prev->slug])}}">
								{{$prev->title}}
							</a>
						@endif
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row" id="comments">
					<div class="col-md-12">
						<div id="disqus_thread"></div>
					</div>
				</div>
			</div>
		</article>
	</div>
@stop