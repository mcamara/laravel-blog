<ul class="links">
	<li @if(Route::currentRouteName() === "index" || Route::currentRouteName() === "viewPost")
			class="active" 
		@endif>
		<a href="{{route('index')}}">
			@lang('messages.home')
		</a>
	</li>
	<li @if(Route::currentRouteName() === "about") class="active" @endif>
		<a href="{{route('about')}}">
			@lang('messages.about')
		</a>
	</li>
	<li @if(Route::currentRouteName() === "projects") class="active" @endif>
		<a href="{{route('projects')}}">
			@lang('messages.projects')
		</a>
	</li>
</ul>