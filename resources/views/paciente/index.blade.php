@extends('layouts.layoutPaciente')

@section('content')
	<div class="dadosCliente">

	</div>
		<div class="boxPrincipal row">
			<div class="listaDeAtendimentos col-xs-3">
				<div class="atendimento">
					aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa				
				</div>
				<div class="atendimento2"> <!-- Teste, div será criada dinamicamente -->
					cccccccccccccccccccccccccccccccccccccccccccccccccccccc
				</div>					
			</div>
			<div class="boxExames row col-sm-9 bdRadius10">
				<div class="dadosAtendimento">
					ddddddddddddddddddddddddddddddddddddddddddddddddd
					ddddddddddddddddddddddddddddddddddddddddddddddddd				
				</div>
				<div class="listaDeExames">
					<div class="row">
		                <div class="col-lg-12">
		                    <div class="ibox">                       
		                            <ul class="sortable-list connectList agile-list ui-sortable">
		                                <li class="warning-element col-md-">
		                                   <b>GLI</b> | GLICEMIA EM JEJUM
		                                    <div class="agile-detail">		                                        
		                                        <i></i> Em Andamento
		                                    </div>
		                                </li>
		                                <li class="success-element">
		                                    <b> TSH </b> | TIREOESTIMULANTE HORMONIO (TSH)
		                                    <div class="agile-detail">		                                        
		                                        <i></i> Finalizado
		                                    </div>
		                                </li>
		                                <li class="info-element">
		                                    Sometimes by accident, sometimes on purpose (injected humour and the like).
		                                    <div class="agile-detail">
		                                        <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
		                                        <i class="fa fa-clock-o"></i> 16.11.2015
		                                    </div>
		                                </li>
		                                <li class="danger-element">
		                                    All the Lorem Ipsum generators
		                                    <div class="agile-detail">
		                                        <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
		                                        <i class="fa fa-clock-o"></i> 06.10.2015
		                                    </div>
		                                </li>                               
		                            </ul>                        
		                    </div>
		                </div>
		                	                
		            </div>
				</div>			
			</div>
		</div>
@stop