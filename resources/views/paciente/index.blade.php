@extends('layouts.layoutPadrao')

@section('infoHead')
	<!--<div class="panel panel-default">
		<span><h4>FRANCILIA CANTANHEDE PINHEIRO</h4>  <hr class="dadosPessoais"> <b>Idade:</b> 20 anos | <b>Sexo</b>: F</span>
	</div>-->

	<ul class="nav navbar-nav pull-right">
		<li class="dropdown">
			<a class="btn dropdown-toggle" data-toggle="dropdown">
				Olá, {{Auth::user()['name']}}
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li class="item">
					<a href="/auth/logout">
						<i class="fa fa-user"></i>
						
					</a>
				</li>
			</ul>
		</li>
	</ul>
@stop

@section('infoAtendimento')
	<div class="infoAtendimento">
		<span>Convênio:</span>
		<span>{{ $atendimentos[0]->nome_convenio}}</span> <br>
		<span>Solicitante:</span>
		<span>{{ $atendimentos[0]->nome_solicitante}}</span>
   	</div>
@stop

