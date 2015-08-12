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
            <nav class="navbar static-top boxDadosAtendimentos" style="margin-bottom: 0">
            <!--<div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>-->

            <ul class="nav navbar-top-links navbar-right">                
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">&nbsp;</a>
                </li>
            </ul>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                              <ul class="sortable-list connectList agile-list ui-sortable">
                                  <li class="warning-element col-md-6">
                                     <b>GLI</b> | GLICEMIA EM JEJUM
                                      <div class="agile-detail">
                                          <i></i> Em Andamento
                                      </div>
                                  </li>
                                  <li class="success-element col-md-6">
                                      <b> TSH </b> | TIREOESTIMULANTE HORMONIO (TSH)
                                      <div class="agile-detail">
                                          <i></i> Finalizado
                                      </div>
                                  </li>
                                   <li class="danger-element col-md-6">
                                      <b>POT</b> | POTASSIO (POT)
                                      <div class="agile-detail">
                                          <i></i> Pendente
                                      </div>
                                  </li>
                              </ul>                        
                        </div>
                    </div>
                </div>
            </div>

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
    @show
</body>
</html>