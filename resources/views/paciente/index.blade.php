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
	  <div class="row infoClientePaciente">
	        <div class="col-md-12">  
	                <div class="infoAtendimento">
	                    <strong>ID</strong>:
	                    <span id="atendimento"></span> <br>
	                    <strong>Convênio</strong>:
	                    <span id="convenio"></span> <br>                          
	                </div>           
	        </div>
    	</div>

	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="ibox">

			<div class="i-checks all boxSelectAll"> </div>
			<ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
		</div>
	</div>
	<div class="footer">
		<div class="pull-left">
			{!!config('system.loginText.footerText')!!}
		</div>
		<div class="pull-right" id="boxRodape">

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
			var posto;
			var atendimento;
			var nomeSolicitante;
			var nomeConvenio;

			var controle;

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
			});

			$("#btnViewExame").click(function(){
				$("#modalExames").modal();
			});

			$('.active a').trigger('click');


			function getExames(posto,atendimento){
				controle = false;

				//Carregando
				$('.listaExames').html('<br><br><br><br><h2 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');

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
						var element = '<a id="btnViewExame" data-toggle="modal" data-target="#modalExames">'+
								'<div class="'+sizeBox+' boxExames">' +
								'<li class="'+exame.class+' animated fadeInDownBig">' +
								'<div class="dadosExames">' +
								'<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+'<br>'+exame.msg+
								'</div>';

						if(saldo == null || saldo == 0 && exame.class == "success-element"){
							controle = true;

							element += '<div class="i-checks checkExames">'+
									'<input type="checkbox" class="check">'+
									'</div>';
						}

						element += '</li></div></a>';
						$('.listaExames').append(element);
					});

					if(controle){
						$('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');

						var checkAll = $('input.checkAll');
						var checkboxes = $('input.check');

						$('input').iCheck({
							checkboxClass: 'icheckbox_square-grey',
						});
					}

					//verifica se o usuario tem saldo devedor
					if(saldo == null || saldo == 0){
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
						$('#boxRodape').html('<h3 class="text-danger">{!!config('system.messages.paciente.saldoDevedor')!!}</h3>');
					}
				}, "json" );
			}
		});
	</script>
@stop