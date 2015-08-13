@extends('layouts.layoutPadrao')

@section('infoHead')
	<!--<div class="panel panel-default">
		<span><h4>FRANCILIA CANTANHEDE PINHEIRO</h4>  <hr class="dadosPessoais"> <b>Idade:</b> 20 anos | <b>Sexo</b>: F</span>
	</div>-->

	<div class="feed-element pull-right infoUser">
       <a href="#" class="boxImgUser">
           {!! Html::image('/assets/images/usuario.jpg','logoUser',array('class' => 'img-circle pull-left')) !!}  
       </a>
       <div class="media-body">
       		<span class="font-bold"><strong>Olá, Jose Varela</strong></span><br>
       		20/05/1975
           	<a class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
			<ul class="dropdown-menu pull-right itensInfoUser">
				<li class="item">
					<a href="/auth/logout">
						<i class="fa fa-user"></i> Log out
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                              <ul class="sortable-list connectList agile-list ui-sortable listaExames">                              	
                                  <!-- <li class="success-element col-md-6"> -->
                                                                                 
                              </ul>                        
                        </div>

                        <div class="teste">
                            <ul>
                              <li></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

@stop

