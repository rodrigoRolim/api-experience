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

    {!! Html::style('/assets/css/skins/'.config('system.skinPadrao')) !!}
    
    <link rel="shortcut icon" href="{{url()}}/assets/images/favicon.ico" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    @section('stylesheets')
        {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}
        @parent
    @show
</head>

<body style="background-color:#FFF">	
    <div id="wraper">
        <div class="container">
			<div class="text-center" style="margin-top: 25vh;">				
				{!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_exp', array('title' => 'eXperience - codemed',)) !!}			
			</div>
			<div class="text-center">
				<h1 style="color:#76C1CC">Ferramenta para visualização de resultados online. </h1>
			</div>
			<div class="text-center">
				<h3 class="lead" style="font-size:16px">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
					Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
					when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				</h3>
			</div>
			<div class="text-center" style="padding-top:40px">
				Desenvolvido por:<br>
				<a href="http://www.codemed.com.br" target="_new">
					{!! Html::image(config('system.devLogo'), 'logo_exp', array('title' => 'Codemed', 'height' => 45)) !!}
				</a>
			</div>
		</div>
	</div>
</body>
    <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript"></script>
</html>