
<header class="container stats">
	<div class="row">
		<div class="col-xs-12 col-sm-6 date">
			@lang('messages.post_posted_on'): 
			<span>{{ date(Lang::get('messages.date_format'), strtotime($post->created_at)) }}</span>
		</div>
		<div class="col-xs-12 col-sm-6 pull-right views">
			@lang('messages.post_views'): 
			<span>{{$post->views}}</span>
			@if($comment_counter)
				 / {{ucfirst(Lang::get('messages.comments'))}}: 
				<a href="{{route('viewPost',['slug'=>$post->slug])}}#comments"> 
					<span class="count-comments" data-disqus-identifier="{{$post->slug}}">
						0
					</span>
				</a>
			@endif
		</div>
	</div>
</header>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			@if($linkable)
				<h2 class="post-title"><a href="{{route('viewPost',['slug'=>$post->slug])}}">{{$post->title}}</a></h2>
			@else
				<h2 class="post-title">{{$post->title}}</h2>
			@endif
		</div>
	</div>
</div>
@if(!empty($post->image))
	<img src="{{url($post->image)}}" class="img-responsive post-image" alt="Post image">
@endif
<div class="container other-info">
	<div class="row">
		<div class="col-sm-5 col-xs-12 post-author">
			@lang('messages.post_written_by'):
			<span rel="author">
				{{$post->author->first_name}} 
				{{$post->author->last_name}}
			</span>
		</div>
		<div class="col-sm-7 col-xs-12 post-categories">
			@lang('messages.categories'):
			<span>
				{{-- rel="tag" when linked --}}
				@if(count($post->categories) == 0)
					@lang('messages.post_no_categorized')
				@else
					<?php $i = 1 ?>
					@foreach($post->categories as $category)
						{{$category->name}}
						<?php $i++ ?>
						@if(count($post->categories) != $i)
							,
						@endif
					@endforeach
				@endif
			</span>
		</div>
	</div>
</div>