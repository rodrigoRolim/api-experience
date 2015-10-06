@extends('layouts.layoutBaseLeft')

@section('stylesheets')
	{!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
@stop

@section('infoHead')
	<div class="feed-element pull-right infoUser">
		<a href="#" class="boxImgUser">
			@if(Auth::user()['sexo'] == 'M')
				{!! Html::image('/assets/images/homem.png','logoUser',array('class' => 'img-circle pull-left')) !!}
			@else
				{!! Html::image('/assets/images/mulher.png','logoUser',array('class' => 'img-circle pull-left')) !!}
			@endif
		</a>
		<div class="media-body">
			<span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span>
			<a class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-caret-square-o-down fa"></b></a><br>
			{{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;
			<ul class="dropdown-menu pull-right itensInfoUser">
				<li class="item">
					<a href="/auth/logout">
						<i class="fa fa-sign-out"></i> Sair
					</a>
				</li>
			</ul>
		</div>
	</div>
@stop

@section('left')
	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="topoMenu">
			<br><br><br>
		</div>
		<ul class="nav metismenu" id="side-menu">
			@foreach($atendimentos as $key => $atendimento)
				<li class="{{ !$key ? 'active' : '' }}">
					<a href="#" class="btnAtendimento"
					   data-posto="{{$atendimento->posto}}"
					   data-atendimento="{{$atendimento->atendimento}}"
					   data-solicitante="{{$atendimento->nome_solicitante}}"
					   data-convenio="{{$atendimento->nome_convenio}}"
					   data-saldo="{{$atendimento->saldo_devedor}}">
						<b class="dataMini">
							<p class="text-center" style="margin:0px;line-height: 14px">{{ date('d/m',strtotime($atendimento->data_atd))}}<br>
								{{ date('Y',strtotime($atendimento->data_atd))}}</p>
						</b>
                        <span class="nav-label mnemonicos"><strong>{{ date('d/m/y',strtotime($atendimento->data_atd))}}</strong><br>
							{{str_limit($atendimento->mnemonicos,56)}}</span>
					</a>
				</li>
			@endforeach
		</ul>
	</nav>
@stop

@section('content')
<div id="page-wrapper" class="gray-bg" style="min-height: 85.6vh;">
	  <div class="row infoCliente">
	        <div class="col-md-12 areaPaciente"> 
        		<div class="col-md-6"> 
	                <div class="infoAtendimento">
	                  	<i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="right" title="Posto/Atendimento"> </i>
	                    <span id="atendimento"></span> <br>
	                    <i class="fa fa-credit-card" data-toggle="tooltip" title="Convênio"> </i>
	                    <span id="convenio"></span> <br>                 
	                </div>
	            </div>
                <div class="col-md-6">                	
                    <i class="fa fa-user-md" data-toggle="tooltip" data-placement="right" title="Médico Solicitante"> </i>
                    <span id="solicitante"></span> <br> 
                </div>  
            </div>                          
        </div> 

	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="ibox">
			<div class="row">
				<div class="i-checks all boxSelectAll"> </div>
			</div>
			<ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
			<!-- Modal -->
              <div class="modal fade" id="modalExames" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2 class="modal-title">Exames Descrição</h2>
                    </div>
                    <div class="modal-body">
                      <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                      
                    </div>
                  </div>
                  
                </div>
              </div>
		</div>
	</div>
	<div class="footer">
		<div class="pull-right" id="boxRodape">	</div>
		<div class="pull-left">
			{!!config('system.loginText.footerText')!!}
		</div>		
	</div>
</div>
@stop

@section('script')
	@parent
	<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function () {
			$("body").tooltip({ selector: '[data-toggle=tooltip]' });

			var posto;
			var atendimento;
			var nomeSolicitante;
			var nomeConvenio;

			$('.btnAtendimento').click(function(e){
				posto = $(e.currentTarget).data('posto');
				atendimento = $(e.currentTarget).data('atendimento');
				nomeSolicitante = $(e.currentTarget).data('solicitante');
				nomeConvenio = $(e.currentTarget).data('convenio');
				saldo = $(e.currentTarget).data('saldo');				

				if(posto != null && atendimento != null){
					getExames(posto,atendimento);
				}

				$('.boxSelectAll').html('');
			});

			$('.page-heading').slimScroll({
				height: '72.5vh',
				railOpacity: 0.4,
				wheelStep: 10,
				minwidth: '100%',
				touchScrollStep: 50,
			});

			$('.modal-body').slimScroll({
                height: '55.0vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            }); 

			$('#side-menu').slimScroll({
				height: '72.5vh',
				railOpacity: 0.4,
				wheelStep: 10,
				minwidth: '100%',
				touchScrollStep: 50,
			});			

			$('.active a').trigger('click');

			function verificaSaldoDevedor(saldo){
                if(saldo == null || saldo == 0){
                   return false;
                }

                return true;
            }

			function getExames(posto,atendimento){
				//Carregando
				$('.listaExames').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
				//Pega os dados via get de exames do atendimento
				$.get( "/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {
					//Carrega dados do atendimento
					$('#solicitante').html(nomeSolicitante);
					$('#convenio').html(nomeConvenio);
					$('#atendimento').html("00/00"+atendimento);

					$('.listaExames').html('');
					$('#boxRodape').html('');

					$.each( result.data, function( index, exame ){
						var sizeBox = 'col-md-6';
						var conteudo = '';
                        var msg = '';
                        var check = '';
                        var link = '';
                        var visualizacao = 'OK';


                        if(!verificaSaldoDevedor(saldo)){
                    	 	if(exame.class == 'success-element'){
                    	 		$('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');
                    	 		 if(exame.tipo_entrega == '*'){
	                        	  	link = '<a id="btnViewExame" data-toggle="modal" data-target="#modalExames" "data-tipoEntrega="'+exame.tipo_entrega+'">';   

	                        	  	visualizacao = "data-visualizacao='OK'"; 

	                        	  	check = '<div class="i-checks checkExames"><input type="checkbox" class="check"></div>';                     	  				
                    		  }else{
            	  	   			msg = '{!!config('system.messages.exame.tipoEntregaInvalido')!!}';
            	  	   			exame.class = "success-elementNoHov";
                	    	}   
                		  }
                		}

						 conteudo = link+'<div class="'+sizeBox+' boxExames "'+
	                                    'data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+'"" '+visualizacao+' "><li class="'+exame.class+' animated fadeInDownBig">'+check+
	                                    '<div class="dadosExames">' +
	                                        '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+
	                                        '<br>'+exame.msg+'<br><span class="msgExameTipoEntrega">'+msg+'</span></li></div>';

						$('.listaExames').append(conteudo);
					});

					 $('.boxExames').click(function(e){	
                            if($(e.currentTarget).data('visualizacao') == 'OK'){
                                var dadosExames = $(e.currentTarget).data();                                               
                                getDescricaoExame(dadosExames);                 
                            }
                            else{
                                return false;
                            }
                    });     

                    function getDescricaoExame(dadosExames){ 
                    	 $('.modal-body').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   
                         $('.modal-title').html('');
                         $('.modal-footer').html('');
                        $.ajax({
                            url : '/paciente/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
                            type: 'GET',                            
                            success:function(result){      
                                var descricao = result.data;  
                                var analitos = result.data.ANALITOS;
                                var conteudo = '';                                                          
                                console.log(descricao);

                                $('#modalExames').modal('show');  
                                                      
                                $('.modal-title').append(descricao.PROCEDIMENTO); 

                                $('.modal-body').html('');

                                $('.modal-footer').append('Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+' - '+
                                    descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Data e Hora da Coleta: '+descricao.DATA_COLETA);


                                $.each( analitos, function( index ){

                                    switch(analitos[index].UNIDADE) {
                                        case 'NULL':
                                            analitos[index].UNIDADE = '';
                                            break;                                                                      
                                    }       

                                    var valorAnalito = analitos[index].VALOR;
                                    if(!isNaN(valorAnalito)){
                                        var valorAnalito = Math.round(analitos[index].VALOR);
                                        valorAnalito = valorAnalito.toFixed(analitos[index].DECIMAIS);
                                    }

                                    conteudo = '<div class ="col-md-12 descricaoExames">'+
                                                 '<div class="col-md-8 analitos">'+
                                                    ''+analitos[index].ANALITO+'</div>'+
                                                 '<div class="col-md-4 valoresAnalitos">'+
                                                    '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong></div>'+
                                                 '</div>';

                                    $('.modal-body').append(conteudo);

                                });             
                           
                                if(result.data.length == 0){
                                    $('.modal-body').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                $('.modal-body').html('');
                                $('.modal-body').append('<div class="text-center alert alert-danger alert-dismissable animated fadeIn erro"><h2>Erro ao carregar Descrição do Exame!</h2></div>');
                            }
                        });
                    }

					var checkAll = $('input.checkAll');
                    var checkboxes = $('input.check');

                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-grey',
                    });
					
					//verifica se o usuario tem saldo devedor
					if(!verificaSaldoDevedor(saldo)){
						$('input.checkAll').on('ifChecked ifUnchecked', function(event) {
							if (event.type == 'ifChecked') {
								checkboxes.iCheck('check');
								$('.btnPdf').show();
							} else {
								checkboxes.iCheck('uncheck');
								$('.btnPdf').hide();
							}
						});

						// Faz o controle do botão de gerar PDF. (Se houver ao menos um selecionado, o botão é habilitado.)
						$('input.check').on('ifChanged', function(event){
							if(checkboxes.filter(':checked').length == 0) {
								$('#boxRodape').html('');
							} else {
								$('#boxRodape').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');
							}
							checkAll.iCheck('update');
						});

						$('input.check').on('ifChanged', function(event){
							if(checkboxes.filter(':checked').length == checkboxes.length) {
								checkAll.prop('checked', 'checked');
							} else {
								checkAll.removeProp('checked');
							}
							checkAll.iCheck('update');
						});


						$('.checkAll').trigger('ifChecked');
					}else{
						$('#boxRodape').html('<h3 class="text-danger msgCliente">{!!config('system.messages.paciente.saldoDevedor')!!}</h3>');
					}
				}, "json" );
			}
		});
	</script>
@stop