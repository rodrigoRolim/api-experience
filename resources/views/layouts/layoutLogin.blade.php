<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-Equiv="Cache-Control" content="no-cache">
	<meta http-Equiv="Pragma" content="no-cache">
	<meta http-Equiv="Expires" content="0"> 
	<title></title>

	{!! Html::style('/assets/css/bootstrap.min.css') !!}
    {!! Html::style('/assets/css/animate.css') !!} 
	{!! Html::style('/assets/css/inspinia.css') !!}
	{!! Html::style('/assets/css/custom.css') !!}

	{!! Html::style('/assets/css/skins/'.config('system.skinPadrao')) !!}

	{!! Analytics::render() !!}
	
	<link rel="shortcut icon" href="{{url()}}/assets/images/favicon.ico" />	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	@section('stylesheets')

	@show
</head>
<body>
	<div id="wraper">
		<div id="header">
			<header>
				<nav class="navbar navbar-static-top headLogin" role="navigation" style="margin-bottom: 0">
					<span>
						<a href="{{url()}}/sobre" target="_blank">
							{!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_lab', array('title' => 'logo', 'class'=>'hidden-xs', 'style' => 'height: 25px; margin-left: 20px')) !!}
							{!! Html::image(config('system.experienceLogo'), 'logo_exp', array('title' => 'eXperience - codemed', 'id' => 'logoRodape', 'class'=>'hidden-sm hidden-md hidden-lg', 'style'=>'margin-right:20px;margin-top:4px;')) !!}
						</a>
					</span>
					<!-- <span class="icon-camera-container">
						<a href="{{url()}}/auth/autoatendimento">
							<span class="camera"><i class="fa-2x fa fa-video-camera"></i></span>
						</a>
					</span>         -->
				</nav>
			</header>
		</div>
		<div id="body">
			<div id="main" role="main">
				<div id="content" class="container-login">
					@yield('content')
				</div>
			</div>
		</div>

		<script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
		<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/assets/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
		<script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
		<script type="text/javascript">
			$.getJSON("{{config('system.datasnap')}}", function (data) {
				var version = data.result[0].Value
				$('#version-ds').text('datasnap: '+version)
        	})
		</script>
		@section('script')

		@show
	</div>
</body>
</html>

