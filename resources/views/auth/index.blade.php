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
<body class="animated fadeInDown gray-bg">
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6 hidden-xs">
                <h2>
                    <a href="{{url('/')}}/sobre">
                        <span class="text-navy">{!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_exp', array('title' => 'eXperience - codemed', 'src'=>'experience/sobre', 'style'=>'height: 80px;')) !!}</span>
                        {!!config('system.loginText.subTitle')!!}
                    </a>
                </h2>
                {!!config('system.loginText.description')!!}
            </div>
            <div class="col-md-6">
                @if (count($errors) == 1)
                    <div class="alert alert-danger alert-dismissable">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                    @if(config('system.acessoPaciente'))
                        <li class=""><a id="btnPaciente" data-toggle="tab" href="#tabLoginPaciente" aria-expanded="false">Paciente</a></li>
                    @endif
                    @if(config('system.acessoMedico'))
                        <li class=""><a id="btnMedico" data-toggle="tab" href="#tabLoginMedico" aria-expanded="false">Médico</a></li>
                    @endif
                    @if(config('system.acessoPosto'))
                        <li class=""><a id="btnPosto" data-toggle="tab" href="#tabLoginPosto" aria-expanded="false">Posto</a></li>
                    @endif                   
                    </ul>
                    <div class="tab-content">
                    @if(config('system.acessoPaciente'))
                        <div id="tabLoginPaciente" class="tab-pane hidden">
                            <div class="panel-body">
                               @include('auth.includes.formLoginPaciente')
                            </div>
                        </div>
                    @endif
                    @if(config('system.acessoMedico'))
                        <div id="tabLoginMedico" class="tab-pane hidden">
                            <div class="panel-body">
                                @include('auth.includes.formLoginMedico')
                            </div>
                        </div>
                    @endif
                    @if(config('system.acessoPosto'))
                        <div id="tabLoginPosto" class="tab-pane hidden">
                            <div class="panel-body">
                                @include('auth.includes.formLoginPosto')
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@stop

@section('script')
<script type="text/javascript"> 
    $(document).ready(function () {
        $('.footer').hide();
        $('li').on('click', function() {
            $('.nav').on('shown.bs.tab', function (e) {
                var tabAtiva = $(e.target).text();
                switch(tabAtiva) {
                    case "Paciente":
                        $('#atendimento').focus();
                        $('#tabLoginPaciente').removeClass('hidden');
                        $('#tabLoginPosto').addClass('hidden');
                        $('#tabLoginMedico').addClass('hidden');
                        break;
                    case "Médico":
                        $('#cr').focus();
                        $('#tabLoginMedico').removeClass('hidden');
                        $('#tabLoginPosto').addClass('hidden');
                        $('#tabLoginPaciente').addClass('hidden');
                        break;
                    case "Posto":
                        $('#posto').focus();
                        $('#tabLoginPosto').removeClass('hidden');
                        $('#tabLoginPaciente').addClass('hidden');
                        $('#tabLoginMedico').addClass('hidden');
                        break;
                }        
            });
        });

        $('.nav-tabs li:first').addClass('active');
        $('.tab-content > div:first-child').addClass('active');
        $('.tab-content > div:first-child').removeClass('hidden');

        var tipoAcesso = "{{Input::old('tipoAcesso')}}";
        var tipoLoginPaciente = "{{Input::old('tipoLoginPaciente')}}";

        switch(tipoAcesso){
            case "PAC":
                $('#btnPaciente').trigger('click');
                break;
            case "MED":
                $('#btnMedico').trigger('click');
                break;
            case "POS":
                $('#btnPosto').trigger('click');
                break;
        } 

        $(document).keypress(function(e) {
            if(e.which == 13) { // enter
                event.preventDefault();
                $('#senha').focus();
            }
        });

    });
</script>
@stop