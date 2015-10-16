@extends('layouts.layoutBaseLeft')

@section('stylesheets')
	{!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
	{!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}  
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
					<a class="btnCadastrarSenha">
						<i class="fa fa-user"></i> Perfil
						<?php var_dump(Auth::user()) ?>
					</a>
				</li>
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
				<li class="leftMenu {{ !$key ? 'active' : '' }}">
					<a href="#" class="btnAtendimento"
					   data-posto="{{$atendimento->posto}}"
					   data-atendimento="{{$atendimento->atendimento}}"
					   data-solicitante="{{$atendimento->nome_solicitante}}"
					   data-convenio="{{$atendimento->nome_convenio}}"
					   data-cpf="{}"
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
        		<div class="col-md-3"> 
	                <div class="infoAtendimento">
	                  	<i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"> </i>
	                    <span id="atendimento"></span>                   
	                </div>
	            </div>
                <div class="col-md-5">    
                	<div class="medicoSolicitante">            	
	                    <i class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"> </i>
	                    &nbsp;<span id="solicitante"></span> 
                	</div>
                </div>  
	            <div class="col-md-4">
	            	<i class="fa fa-credit-card" data-toggle="tooltip" data-placement="bottom" title="Convênio"> </i>
                    <span id="convenio"></span>                 
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
                
                  <!-- Área Modal -->
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

              <!-- Modal Cadastrar Senha Paciente -->
              <div class="modal fade" id="modalCadastrarSenha" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Área Modal -->
                  <div class="modal-conteudo">
                    <div class="modal-topo">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2 class="modal-titulo">Perfil</h2>
                    </div>
	                <div class="modal-corpo">
			           <div class="col-md-12">
			           	{!! Form::open(array('id' => 'formPefil')) !!}   
			           			<div class="col-md-6">                   		
			          			  <div class="form-group">
			          			  	{!! Form::label('cpf', 'CPF') !!}
			          			  	{!! Form::text('cpf','',array('class' => 'form-control', 'id' =>'CPF', 'placeholder' => 'CPF' )) !!}
								  </div>
								  <div class="form-group">
								  	{!! Form::label('DataNascimento', 'Data de Nascimento') !!}
			          			  	{!! Form::text('dataDeNascimento','',array('class' => 'form-control', 'id' =>'dataDeNascimento', 'placeholder' => 'Data de Nascimento' )) !!}								    
								  </div>
								</div>
								<div class="col-md-6">
								  <div class="form-group">
								  	{!! Form::label('SenhaAtual', 'Senha Atual') !!}
			          			  	{!! Form::password('senhaAtual',array('class' => 'form-control', 'id' =>'senhaAtual', 'placeholder' => 'SenhaAtual' )) !!}								   
								  </div>
								   <div class="form-group">
								   	{!! Form::label('novaSenha', 'Nova Senha') !!}
			          			  	{!! Form::password('novaSenha',array('class' => 'form-control', 'id' =>'novaSenha', 'placeholder' => 'Nova Senha' )) !!}								
								  </div>
								   <div class="form-group">
								   	{!! Form::label('confNovaSenha', 'Confirmar Nova Senha') !!}
			          			  	{!! Form::password('confNovaSenha',array('class' => 'form-control', 'id' =>'confNova Senha', 'placeholder' => 'Confirmar Nova Senha' )) !!}				
								  </div>
								</div>					  
			          	</div>      
			        </div>
			        <div class="modal-rodape">
			          <a class="btn btn-success" id="btnSalvarPerfil">Salvar</a>
			          		{!! Form::close() !!}
			        </div>
                  </div>
                  
                </div>
              </div>
		</div>
	</div>
	<div class="footer">
		<div class="row col-md-12">
			<div class="col-md-4 pull-right" id="boxRodape">	</div>
			<div class="col-md-8 txtRodape">	</div>	
		</div>	
	</div>
</div>
@stop

@section('script')
	@parent
	<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/validate/jquery.validate.min.js') }}"></script>
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

			$('.btnCadastrarSenha').click(function(e){
				$('#modalCadastrarSenha').modal('show');
			});

			VMasker($("#dataDeNascimento")).maskPattern('99/99/9999');
			$('#dataDeNascimento').datepicker({
	            startView: 1,
	            todayBtn: "linked",
	            keyboardNavigation: true,
	            forceParse: false,
	            autoclose: true,
	            format: "dd/mm/yyyy"
	        });

	        VMasker($('#cpf')).maskPattern('999.999.999-99');    

			$('.page-heading').slimScroll({
				height: '71.1vh',
				railOpacity: 0.4,
				wheelStep: 10,
				minwidth: '100%',
				touchScrollStep: 50,
			});

			 $('#btnSalvarPerfil').click(function(e){
                var formSetSenha = $('#formPerfil');
                var postData = formSetSenha.serializeArray();

                console.log(postData);
            });

			$('.modal-body').slimScroll({
                height: '55.0vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            }); 

			$('#side-menu').slimScroll({
				height: '67.2vh',
				railOpacity: 0.4,
				wheelStep: 10,
				minwidth: '100%',
				touchScrollStep: 50,
			});			

			$('.leftMenu.active a').trigger('click');

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

	                        	  	check = '<div class="i-checks checkExames" data-posto="'+exame.posto+'" data-atendimento="'+exame.atendimento+'"><input type="checkbox" class="check" value="'+exame.correl+'"></div>';                     	  				
                    		  }else{
            	  	   			msg = '{!!config('system.messages.exame.tipoEntregaInvalido')!!}';
            	  	   			exame.class = "success-elementNoHov";
            	  	   			check = '';
                                $('.boxSelectAll').html('');
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

                    $('#boxRodape').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');             

                    var checkAll = $('input.checkAll');
                    var checkboxes = $('input.check');

                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-grey',
                    });

                    if(checkboxes.filter(':checked').length == 0) { 
                        $('.btnPdf').hide();
                    }

                    //verifica se o usuario tem saldo devedor
                    if(!verificaSaldoDevedor(saldo)){
                        $('input.checkAll').on('ifChecked ifUnchecked', function(event) {
                            if (event.type == 'ifChecked') {
                                checkboxes.iCheck('check');                               
                            } else {
                                checkboxes.iCheck('uncheck');                                
                            }
                        });

                        // Faz o controle do botão de gerar PDF. (Se houver ao menos um selecionado, o botão é habilitado.)
                        $('input.check').on('ifChanged', function(event){
                            if(checkboxes.filter(':checked').length == 0) {                            	
                                $('.btnPdf').hide();
                            }else{                            	 
	                            $('.btnPdf').show();
	                            checkAll.iCheck('update');
	                        }
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

						 $('.btnPdf').click(function(e){	
			                 var checkboxes = $('input.check:checked');					                 
			                 var posto = $('.checkExames').data('posto');
			                 var atendimento = $('.checkExames').data('atendimento');

			                 var correl = [];
			                 checkboxes.each(function () {
                                    correl.push($(this).val());
                                });   

			                 var dadosExame = {};			                
         					 dadosExame = [{'posto':posto,'atendimento':atendimento,'correlativos':correl}];
         					 var paginaPdf = window.open ('', '', '');       
                             paginaPdf.document.write("<br><h2 class='textoTamanho'><b><span class='fa fa-refresh iconLoad'></span><br>Exportando PDF com os exames selecionados.</br><small>Esse processo pode levar alguns instantes. Aguarde!</small></h1>");			                 	                 

			                 $.ajax({ // Faz verificação de dados do cliente dentro do formulario(modal) de cadastrar senha.
						         url: 'paciente/exportarpdf',
						         type: 'post',
						         data: {"dados" : dadosExame},
						         success: function(data){   
						         		paginaPdf.location = data; 		         
						           }

						        });		     
			            });   

					}else{
						$('#boxRodape').html('<h3 class="text-danger msgCliente">{!!config('system.messages.paciente.saldoDevedor')!!}</h3>');
					}
				}, "json" );
			}
		});			
            $(".txtRodape").append("<span class='statusAtendimentosViewPaciente'></span>");            
            $(".statusAtendimentosViewPaciente").append(" <span class='statusFinalizados'></span>&nbsp; Finalizados &nbsp;&nbsp;<span class='statusAguardando'></span> Parc. Finalizado");
            $(".statusAtendimentosViewPaciente").append("&nbsp;&nbsp;<span class='statusEmAndamento'></span> Em Andamento &nbsp;&nbsp;<span class='statusPendencias'></span> Existem Pendências");
            $(".txtRodape").append('<br><span class="devFooter">{!!config('system.loginText.footerText')!!}</span>');
	</script>
@stop