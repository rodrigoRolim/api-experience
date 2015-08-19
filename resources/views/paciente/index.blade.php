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
		<span><strong>Convênio</strong>:</span>
		<span>{{ $atendimentos[0]->nome_convenio}}</span> <br>
		<span><strong>Solicitante</strong>:</span>
		<span>{{ $atendimentos[0]->nome_solicitante}}</span>
   	</div>	
</div>
@stop

@section('exames')

	 <div class="row wrapper border-bottom white-bg page-heading">
		<div class="ibox">			
			<div class="i-checks all">			
				<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>	
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
			$('.btnAtendimento').click(function(e){
				var posto = $(e.currentTarget).data('posto');
				var atendimento = $(e.currentTarget).data('atendimento');

				if(posto != null && atendimento != null){
					getExames(posto,atendimento);
				}

			});

			$('.active a').trigger('click');


			function getExames(posto,atendimento){
				$('.listaExames').html('<br><br><br><br><h2 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
				$.get( "/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {
					$('.listaExames').html('');

					$.each( result.data, function( index, exame ){

						var sizeBox = 'col-md-6';

						$('.listaExames').append('<div class="'+sizeBox+' boxExames">' +
									'<li class="'+exame.class+' animated fadeInDownBig">' +
										'<div class="dadosExames">' +
										'<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+'<br>'+exame.msg+
										'</div><div class="i-checks checkExames"><input type="checkbox" class="check">'+
										'</div><button type="button" class="btn btn-success btn-sm btnVisualizarExame" data-toggle="modal"'+
										'data-target="#myModal">Ver</button>'+
									'</li>' +
								'</div>');

						$('input').iCheck({
							checkboxClass: 'icheckbox_square-grey',
						});
					
						
						var checkAll = $('input.checkAll');
					    var checkboxes = $('input.check');	 

					    
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
					});
				}, "json" );
			}
		});
	 $('.btnPdf').hide(); // Esconde botão gerar PDF por padrão.
	</script>
@stop