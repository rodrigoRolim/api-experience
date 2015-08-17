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

<body class="gray-bg boxed-layout bodyLayoutPadrao">
	<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
    	<header>
  			<nav class="navbar navbar-static-top headLogin headPadrao" role="navigation" style="margin-bottom: 0">
  				<div class="navbar-header logo">
            {!! Html::image('/assets/images/logo.png', 'logo_lab', array('title' => 'logo')) !!}  
  		    </div>		
		     	@yield('infoHead')
  			</nav> 	
	    </header>
    </div>
  </nav>

    <div class="container">
    	<div id="wrapper">
    		@include('layouts.includes.layoutPadrao.left')
	        <div id="page-wrapper" class="gray-bg" style="min-height: 356px;">
            <div class="row border-bottom">
            @yield('infoAtendimento')
        </div> 
          @yield('exames')
            <div class="footer">               
                <div class="pull-right">
                    <strong>Copyright</strong> Codemed © 2014-2015
                </div>
            </div>
        </div>
    	</div>
    </div>
    
    @section('script')
      <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
      <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>


      <script type="text/javascript">

        $(function(){
          $('.page-heading').slimScroll({
              height: '78.6vh',
              railOpacity: 0.4,
              wheelStep: 10,
              minwidth: '100%',
          });
        });


      </script>

    @show
</body>
</html>