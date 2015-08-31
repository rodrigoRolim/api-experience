@extends('layouts.layoutPaciente')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
@show
@section('infoAtendimento')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-10">
                <div class="infoAtendimento">
                    <span><strong>Convênio</strong>:</span>
                    <span id="convenio"></span> <br>
                    <span><strong>Solicitante</strong>:</span>
                    <span id="solicitante"></span>
                </div>
            </div>
			<span class="atendimento"><strong>ID</strong>:
				<span id="atendimento"></span></span>
        </div>
    </div>
@stop

@section('exames')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <div class="i-checks all boxSelectAll">

            </div>

            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
        </div>
    </div>


@stop