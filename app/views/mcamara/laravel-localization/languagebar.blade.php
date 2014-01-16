	@foreach($languages as $key => $lang)
		@if($key != $active)
			<a rel="alternate" hreflang="{{$key}}" href="{{$urls[$key]}}">{{$lang}}</a></li>
		@endif
	@endforeach
