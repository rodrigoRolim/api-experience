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

    	{!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}   

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
  	<div class="bodyMedico">
	    <div class="container">    
	    	<body class="gray-bg boxed-layout">		          
		    		<div class="col-md-12 corPadrao boxFiltro">
		    			<div class="col-md-3">
		    				<label class="textoBranco">Atendimentos por datas entre:</label>
		            		<div class="input-daterange input-group" id="datepicker">
	                            <input type="text" class="input-sm form-control" name="start" value="05/14/2014">
	                            	<span class="input-group-addon">até</span>
	                            <input type="text" class="input-sm form-control" name="end" value="05/22/2014">
	                        </div>
	                    </div>	                  
	                	<div class="col-md-2">
	                		<label class="textoBranco">Posto Realizante</label>
	                		<select class="form-control m-b" name="postoRealizante">
                                <option>Selecione</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                            </select>
	                	</div>	                
	                	<div class="col-md-3">
	                			<label class="textoBranco">Convênios</label>
	                		<select class="form-control m-b" name="convenios">
                                <option>Selecione</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                            </select>
	                	</div>
	                	<div class="col-md-2">
	                		<label class="textoBranco">Situação</label>
	                		<select class="form-control m-b" name="situacao">
                                <option>Selecione</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                            </select>
	                	</div>
	                	<div class="col-md-2">
	                		<div class="input-group m-b filtrar col-md-12" style="margin-bottom:0px;padding-top:18px;"> <!-- COLOCAR NO CUSTOM.css  -->                           
		                		<a class="btn btn-warning btn-outline btnFiltar"><i class="fa fa-filter fa-2"> </i> Filtrar</a>
	                		</div>	
	                	</div>
	            	</div> 
            <div class="wrapper wrapper-content">
                <div class="middle-box text-center animated">
                    <div class="ibox-content">
                    	<div class="row">
                        	<div class="col-md-12">	                       	
		                    	<div class="input-group m-b">
		                    		<span class="input-group-addon"><i class="fa fa-search"></i></span> 
		                    		<input type="text" id="filterTeste" placeholder="Paciente/Atendimento" class="form-control">
                                </div>
                                <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter">
                                    <li class="col-md-12 warning-element">
                                        <div class="col-md-6 dadosPaciente">
                                            <i class="fa fa-mars"></i> Joao <br>
                                            Idade: 30 Anos | Contato (98) 99999-9999 <br>
                                        </div>
                                        <div class="col-md-6">
                                            22/08/2015 <b>00/002058</b> |
                                            23/08/2015 <b>00/002054</b> |
                                            25/08/2015 <b>00/002053</b> |
                                        </div>                                                                          
                                    </li>
                                    <li class="col-md-12 success-element">
                                        <div class="col-md-6 dadosPaciente">
                                            <i class="fa fa-venus"></i> Maria <br>
                                            Idade: 70 Anos | Contato (98) 99999-9999 <br>
                                        </div>
                                        <div class="col-md-6">
                                            22/08/2015 <b>00/002058</b> |
                                            23/08/2015 <b>00/002054</b> |
                                            25/08/2015 <b>00/002053</b> |
                                        </div>   
                                    </li>                   
                                </ul>	                        
	                        </div>
	                    </div>
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
      <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
      <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>

      <script type="text/javascript">

        $('.input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });


        $('#filterTeste').filterList();
 

      </script>

    @show

</div>
</html>