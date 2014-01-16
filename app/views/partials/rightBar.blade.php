{{--DESKTOP--}}
<div class="right-bar-container right-bar-container-desktop visible-md visible-lg bounceInRight animated">
	<nav class="right-bar-desktop" role="navigation">
		<h1>Marc <br/>C&aacute;mara</h1>
		<h2>Software Engineer</h2>
		@include('partials/menuLinks')
		@include('partials/menuSocial')
	</nav>
</div>

{{--MOBILE--}}
<div class="right-bar-container right-bar-container-mobile visible-sm visible-xs bounceInUp animated">
	<nav class="right-bar-mobile" role="navigation">
		<h1>Marc C&aacute;mara</h1>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<h2>Software Engineer</h2>
			</div>
			<div class="col-sm-6 col-xs-12">
				@include('partials/menuSocial')
			</div>
		</div>
		@include('partials/menuLinks')
	</nav>
</div>