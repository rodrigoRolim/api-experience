@extends('layouts.layoutPadrao')

@section('infoHead')
	<div class="feed-element pull-right infoUser">
       <a href="#" class="boxImgUser">
           {!! Html::image('/assets/images/usuario.jpg','logoUser',array('class' => 'img-circle pull-left')) !!}  
       </a>
       <div class="media-body">
       		<span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span><br>
       		{{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;
           	<a class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-sign-out"></b></a>
			<ul class="dropdown-menu pull-right itensInfoUser">
				<li class="item">
					<a href="/auth/logout">
						<i class="fa fa-user"></i> Sair
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

