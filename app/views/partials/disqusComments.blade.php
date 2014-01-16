<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'marccamara'; // required: replace example with your forum shortname
	var disqus_config = function () { 
		@if(Config::get('application.language') == "es")
			this.language = "es_ES";
		@elseif(Config::get('application.language') == "ca")
			this.language = "ca_ES";
		@else
			this.language = "en";
		@endif
	}; 
	var disqus_identifier = "{{$post->slug}}";
	var disqus_title = "{{$post->title}}";
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>