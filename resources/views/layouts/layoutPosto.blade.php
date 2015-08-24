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

	<div id="wraper">
	
    <div class="container">
    	<div id="header">	  
	  			<nav class="navbar navbar-static-top headLogin headPadrao" role="navigation" style="margin-bottom: 0">
	  				<div class="navbar-header logo">
	            {!! Html::image('/assets/images/logo.png', 'logo_lab', array('title' => 'logo')) !!}  
	  			</nav> 			  
		</div>
    </div>
  </nav>

  	<div id="body">
	    <div class="container">    
	    	<body class="gray-bg boxed-layout">		          
	            <div class="wrapper wrapper-content">
	                <div class="middle-box text-center animated fadeInRightBig">
	                    <h3 class="font-bold">This is page content</h3>
	                   
	                        <div class="ibox-content">

                            <ul class="sortable-list connectList agile-list ui-sortable">
                                <li class="warning-element">
                                    Simply dummy text of the printing and typesetting industry.
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                        <i class="fa fa-clock-o"></i> 12.10.2015
                                    </div>
                                </li>
                                <li class="success-element">
                                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                        <i class="fa fa-clock-o"></i> 05.04.2015
                                    </div>
                                </li>
                                <li class="info-element">
                                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                        <i class="fa fa-clock-o"></i> 16.11.2015
                                    </div>
                                </li>
                                <li class="danger-element">
                                    All the Lorem Ipsum generators
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                                        <i class="fa fa-clock-o"></i> 06.10.2015
                                    </div>
                                </li>
                                <li class="warning-element">
                                    Which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                        <i class="fa fa-clock-o"></i> 09.12.2015
                                    </div>
                                </li>
                                <li class="warning-element">
                                    Packages and web page editors now use Lorem Ipsum as
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                                        <i class="fa fa-clock-o"></i> 08.04.2015
                                    </div>
                                </li>
                                <li class="success-element">
                                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                        <i class="fa fa-clock-o"></i> 05.04.2015
                                    </div>
                                </li>
                                <li class="info-element">
                                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                        <i class="fa fa-clock-o"></i> 16.11.2015
                                    </div>
                                </li>
                            </ul>
                        </div>	                                        
	                </div>
	            </div> 
    	</div>
    </div>
    	<div id="footer">
				@include('layouts.includes.footer')
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
</div>
</html>