<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title></title>

	{!! Html::style('/assets/css/bootstrap.min.css') !!}

    {!! Html::style('/assets/css/animate.css') !!} 
	{!! Html::style('/assets/css/inspinia.css') !!}
	{!! Html::style('/assets/css/custom.css') !!} 
	{!! Html::style('/assets/css/skins/red.css') !!} 
	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	@section('stylesheets')
		
	@show
</head>
<body class="gray-bg">	
	@include('paciente.includes.head')
	<div id="main" role="main">
    	<div class="content">
			@yield('content')
		</div>
	</div>

	<footer>
		@include('layouts.includes.footer')
	</footer>

	<script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
	<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
	
	@section('script')

	@show
</body>
</html>