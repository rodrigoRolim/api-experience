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
          @yield('infoHead') 			  
		</div>
    </div>
  	<div class="bodyMedico">
	    <div class="container">    
	    	<body class="gray-bg boxed-layout">		          
		    		<div class="col-md-12 corPadrao boxFiltro">
		    			<div class="col-md-3">
                    <form id="formMedico">
		    				<label class="textoBranco">Atendimentos por datas entre:</label>
		            		<div class="input-daterange input-group" id="datepicker">
	                            <input type="text" class="input-sm form-control" id="dataInicio" name="dataInicio">
	                            	<span class="input-group-addon">até</span>
	                            <input type="text" class="input-sm form-control" id="dataFim" name="dataFim">
	                        </div>
	                    </div>	                  
	                	<div class="col-md-2">
	                		<label class="textoBranco" name="posto">Posto Realizante</label>
	                		{!! Form::select('posto', $postos, '', array('class' => 'form-control m-b', 'id'=>'posto')) !!}
	                	</div>	                
	                	<div class="col-md-3">
	                		<label class="textoBranco" name="convenio">Convênios</label>
	                		{!! Form::select('convenio', $convenios, '', array('class' => 'form-control m-b', 'id'=>'convenio')) !!}
	                	</div>
	                	<div class="col-md-2">
	                		<label class="textoBranco" name="situacao">Situação</label>
                            {!! Form::select('situacao', config('system.selectFiltroSituacaoAtendimento'), '', array('class' => 'form-control m-b', 'id'=>'situacao')) !!}
	                	</div>
	                	<div class="col-md-2">
	                		<div class="input-group m-b filtrar col-md-12" style="margin-bottom:0px;padding-top:17px;"> <!-- COLOCAR NO CUSTOM.css  -->                           
		                		<a class="btn btn-warning btn-outline btnFiltar"><i class="fa fa-filter fa-2"> </i> Filtrar</a>
	                		</div>	
                    </form>
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
                                <ul class="sortable-list connectList agile-list ui-sortable listaPacientes" id="listFilter">
                              <!-- <li class="col-md-12 warning-element">
                                        <div class="col-md-6 dadosPaciente">
                                            <i class="fa fa-mars"></i> Joao <br>
                                            Idade: 30 Anos | Contato (98) 99999-9999 <br>
                                        </div>
                                        <div class="col-md-6">
                                            22/08/2015 <b>00/002058</b> |                                          
                                        </div>                                                                          
                                    </li>
                                    <li class="col-md-12 success-element">
                                        <div class="col-md-6 dadosPaciente">
                                            <i class="fa fa-venus"></i> Maria <br>
                                            Idade: 70 Anos | Contato (98) 99999-9999 <br>
                                        </div>
                                        <div class="col-md-6">
                                            22/08/2015 <b>00/002047</b> |
                                            23/08/2015 <b>00/002025</b> |
                                            25/08/2015 <b>00/002053</b> |
                                        </div>  
                                    </li>   -->                 
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
      <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
      <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>

      <script type="text/javascript">
        $(document).ready(function () {

          $('.input-daterange').datepicker({
              keyboardNavigation: true,
              forceParse: false,
              autoclose: true,
              format: "dd/mm/yyyy"
          });

          var dataInicio = new moment();
          var dataFim = new moment();
          var qtdDiasFiltro = {{config('system.medico.qtdDiasFiltro')}};
         
          dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
          dataInicio = dataInicio.format('DD/MM/YYYY');
          dataFim = dataFim.format('DD/MM/YYYY');
         
          $('#dataInicio').val(dataInicio);
          $('#dataFim').val(dataFim);

          $('.btnFiltar').trigger('click');
            $(function(){
              $('.listaPacientes').slimScroll({
                  height: '58.6vh',
                  railOpacity: 0.4,
                  wheelStep: 10,
                  minwidth: '100%',
              });
            });
          });

        $('#filterTeste').filterList();

        $('.btnFiltar').click(function(e){
              var formMedico = $('#formMedico');
              var postData = formMedico.serializeArray();   

              getClientes(postData);      
        });    

        function getClientes(postData){
          $('.listaPacientes').html('<br><br><br><br><h2 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
             $.ajax(
                {
                   url : 'medico/filterclientes',
                   type: 'POST',
                   data : postData,
                   success:function(result){

                  $('.listaPacientes').html('');

                  $.each( result.data, function( index ){

                    var cliente = result.data[index];

                    var item =   '<li class="col-md-12 naoRealizado-element" data-id="'+cliente.registro+'">'+
                                    '<div class="col-md-4 dadosPaciente text-left">'+
                                      '<strong><i class="'+((cliente.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> '+cliente.nome+'</strong> - XX Anos'+
                                    '</div>'+
                                    '<div class="col-md-3 text-left"><span class="ajusteFonte">Contato: '+cliente.telefone+' </span></div>'+
                                    '<div class="com-md-5 text-left"><span class="ajusteFonte">Últ. Atendimentos: </span>';
                                    
                    var count = 0;

                    $.each( cliente.atendimentos, function( index ){
                      count++;
                      var atendimento = cliente.atendimentos[index];

                      item += '<span class="label labelAtendimentosClientes">'+atendimento+"</span>";
                      
                      if(count == 3){
                        return false;
                      }

                    });

                    item += '</div></div></li>';

                    $('.listaPacientes').append(item); 
                  
                    });

                    $('.listaPacientes li').click(function(e){       
                      var registro = $(e.currentTarget).data('id');
                      registro = btoa(registro);
                      window.location.replace("/medico/paciente/"+registro);
                    });

                   },
                   error: function(jqXHR, textStatus, errorThrown) 
                   {
                       var msg = jqXHR.responseText;
                       msg = JSON.parse(msg);

                       $('#msgPrograma').html('<div class="alert alert-danger alert-dismissable animated fadeIn">'+msg.message+'</div>');
                   }
                });           
        }

      </script>

    @show

</div>
</html>