@extends('layouts.layoutPadrao')

@section('stylesheets')
	{!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
	<style type="text/css">
		.i-checks{
			float: right;
		}
	</style>
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
	<div class="infoAtendimento">
		<span>Convênio:</span>
		<span>{{ $atendimentos[0]->nome_convenio}}</span> <br>
		<span>Solicitante:</span>
		<span>{{ $atendimentos[0]->nome_solicitante}}</span>
   	</div>
@stop

@section('exames')

	 <div class="row wrapper border-bottom white-bg page-heading">
		<div class="ibox">
			<ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
		</div>
	 </div>
@stop

@section('script')
	@parent
	<script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>

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
				$('.listaExames').html('<br><br><br><br><h1 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
				$.get( "/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {
					$('.listaExames').html('');

					$.each( result.data, function( index, exame ){

						var sizeBox = 'col-md-6';

						$('.listaExames').append('<div class="'+sizeBox+' boxExames">' +
							'<li class="'+exame.class+' animated fadeInDownBig">' +
								'<div class="row">' +
									'<div class="col-xs-10">' +
										'<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento+'<br>'+exame.msg+'' +
									'</div>'+
									'<div class="col-md-2">'+
										'<div class="i-checks"><input type="checkbox"></div>' +
									'</div>'+
								'</div>'+
							'</li></div>');

						$('.i-checks').iCheck({
							checkboxClass: 'icheckbox_square-grey',
						});
					});
				}, "json" );
			}
		});
	</script>
@stop