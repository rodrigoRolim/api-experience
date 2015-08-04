@extends('layouts.layoutLogin')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}    
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}

    <style type="text/css">
        .i-checks{
            margin-bottom: 10px;
        }
    </style>
@stop

@section('content')
<body class="gray-bg">
	<div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>
                    <span class="text-navy">{{config('system.loginText.title')}}</span>
                	{!!config('system.loginText.subTitle')!!}
                </h2>
                {!!config('system.loginText.description')!!}
            </div>
            <div class="col-md-6">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tabLoginPaciente" aria-expanded="true">Paciente</a></li>
                        <li class=""><a data-toggle="tab" href="#tabLoginMedico" aria-expanded="false">Médico</a></li>
                        <li class=""><a data-toggle="tab" href="#tabLoginPosto" aria-expanded="false">Posto</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabLoginPaciente" class="tab-pane active">                           
                            <div class="panel-body">
                               @include('auth.includes.formLoginPaciente')
                            </div>
                        </div>
                        <div id="tabLoginMedico" class="tab-pane">
                            <div class="panel-body">
                                @include('auth.includes.formLoginMedico')
                            </div>
                        </div>
                        <div id="tabLoginPosto" class="tab-pane">
                            <div class="panel-body">
                                @include('auth.includes.formLoginPosto')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@stop