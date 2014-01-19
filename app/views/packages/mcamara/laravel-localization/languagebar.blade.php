    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($url = LaravelLocalization::getLocalizedURL($localeCode) and $localeCode != LaravelLocalization::getCurrentLanguage())
            <a rel="alternate" hreflang="{{$localeCode}}" href="{{$url}}">{{{ !empty($abbr) ? $localeCode : $properties['native'] }}}</a>
        @endif
    @endforeach
