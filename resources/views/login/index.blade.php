@extends('layouts.layoutLogin')

@section('content')


<body class="gray-bg">
	<div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>
                	<span class="text-navy">INSPINIA - Responsive Admin Theme</span>
                	<br><br>is provided with two main layouts 
                    <br>three skins and separate configure options.
                </h2>
                <p>
                    Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                </p>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                </p>
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
                                @include('login.includes.formLoginPaciente')
                            </div>
                        </div>
                        <div id="tabLoginMedico" class="tab-pane">
                            <div class="panel-body">
                                @include('login.includes.formLoginMedico')                                
                            </div>
                        </div>
                        <div id="tabLoginPosto" class="tab-pane">
                            <div class="panel-body">
                                @include('login.includes.formLoginPosto')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@stop