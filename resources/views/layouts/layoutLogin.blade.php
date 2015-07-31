<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title></title>

	{!! Html::style('/assets/css/bootstrap.min.css') !!}
    {!! Html::style('/assets/css/font-awesome/css/font-awesome.min.css') !!} 

    {!! Html::style('/assets/css/animate.css') !!} 
	{!! Html::style('/assets/css/inspinia.css') !!}
	{!! Html::style('/assets/css/custom.css') !!} 
	{!! Html::style('/assets/css/skins/red.css') !!} 
	
	<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700"> --> 	

	@section('stylesheets')
		
	@show
</head>
<body class="animated fadeInDown gray-bg">
	@include('layouts.includes.head')
	
	<div id="main" role="main">
    	<div id="content" class="container">
			@yield('content')
		</div>
	</div>

	<footer>
		@include('layouts.includes.footer')
	</footer>

	<script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
	<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
	
	@section('script')

	@show
</body>
</html>