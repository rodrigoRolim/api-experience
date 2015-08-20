@extends('layouts.layoutPadrao')

@section('stylesheets')
	{!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
@show

@section('infoHead')
	<div class="feed-element pull-right infoUser">
       <a href="#" class="boxImgUser">
           {!! Html::image('/assets/images/usuario.jpg','logoUser',array('class' => 'img-circle pull-left')) !!}  
       </a>
       <div class="media-body">
       		<span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span><br>
       		{{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;	
           	<a class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
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

@section('infoAtendimento')
<div class="boxDadosAtendimentos">
	<div class="infoAtendimento">
		<span id="saldo">{{ $atendimentos[0]->saldo_devedor}}</span>
		<span><strong>Convênio</strong>:</span>
		<span id="convenio"></span> <br>
		<span><strong>Solicitante</strong>:</span>
		<span id="solicitante"></span>
   	</div>	
</div>
@stop

@section('exames')

	 <div class="row wrapper border-bottom white-bg page-heading">
		<div class="ibox">			
			<div class="i-checks all boxSelectAll">
				
			</div>
			
			<ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>	

			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Modal Header</h4>
			      </div>
			      <div class="modal-body">
			        	<p>Some text in the modal.</p>
			      </div>
			      <div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
		  	</div>
		</div>				  
	</div>
 </div>
@stop

@section('script')
	@parent
	<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>

	<script type="text/javascript">	
		$(document).ready(function () {
			var posto;
			var atendimento;
			var nomeSolicitante;
			var nomeConvenio;
			var saldo;

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

			$('.active a').trigger('click');


			function getExames(posto,atendimento){
				$('.listaExames').html('<br><br><br><br><h2 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
				$.get( "/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {
					//Carrega dados do atendimento
					$('#solicitante').html(nomeSolicitante);
					$('#convenio').html(nomeConvenio);
					$('#saldo').html('Saldo: '+saldo);

					$('.listaExames').html('');

					$.each( result.data, function( index, exame ){

						var sizeBox = 'col-md-6';

						var element = '<a data-toggle="modal" data-target="#myModal">'+
											'<div class="'+sizeBox+' boxExames">' +
											  	'<li class="'+exame.class+' animated fadeInDownBig">' +
													'<div class="dadosExames">' +
														'<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+'<br>'+exame.msg+
													'</div>';
						
						if(saldo == null || saldo == 0){
							element += '<div class="i-checks checkExames">'+
								'<input type="checkbox" class="check">'+
							'</div>';

							$('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');
						}
						
						element += '</li></div></a>';

						$('.listaExames').append(element);
					});

					//verifica se o usuario tem saldo devedor
					if(saldo == null || saldo == 0){						    
						var checkAll = $('input.checkAll');
						var checkboxes = $('input.check');	 

						$('input').iCheck({
							checkboxClass: 'icheckbox_square-grey',
						});

					    checkAll.on('ifChecked ifUnchecked', function(event) {        
					        if (event.type == 'ifChecked') {
					            checkboxes.iCheck('check');
					            $('.btnPdf').show();
					        } else {
					            checkboxes.iCheck('uncheck');
					            $('.btnPdf').hide();
					        }
					    });

					    // Faz o controle do botão de gerar PDF. (Se houver ao menos um selecionado, o botão é habilitado.)
					    checkboxes.on('ifChanged', function(event){ 
					        if(checkboxes.filter(':checked').length == 0) {
					               $('.btnPdf').hide();
					        } else {
					               $('.btnPdf').show();
					        }
					        checkAll.iCheck('update');
					    });		

					    checkboxes.on('ifChanged', function(event){
					        if(checkboxes.filter(':checked').length == checkboxes.length) {
					            checkAll.prop('checked', 'checked');
					        } else {
					            checkAll.removeProp('checked');
					        }
					        checkAll.iCheck('update');
					    });

					    $('#boxRodape').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');
					     $('.btnPdf').hide();
					}else{
						$('#boxRodape').html('<h3 class="text-danger">{!!config('system.messages.paciente.saldoDevedor')!!}</h3>');
					}
				}, "json" );
			}
		});
	
	</script>
@stop