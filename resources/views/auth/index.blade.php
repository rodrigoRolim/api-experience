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
    <div class="container-auth animated fadeInDown">
        <div class="container-login">
            <div class="info-logo container-info">
                
                <h2>
                    <a id="linkSobre" href="{{url('/')}}/sobre">
                        <span class="text-navy">{!! Html::image(config('system.clienteLogo'), 'logo_exp', array('title' => 'eXperience - codemed', 'src'=>'experience/sobre', 'style'=>'height: 90px;')) !!}</span>
                        {!!config('system.loginText.subTitle')!!}
                    </a>
                </h2>
                <div class="versions">
                    <small>experience: {!!config('system.versao')!!}</small>
                    <small id="version-ds"></small>
                </div>
               <!--  {!!config('system.loginText.description')!!} -->
            </div>
            <div class="tabs-body">
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
                    @if(!$mobile && config('system.acessoPosto'))
                        <li class=""><a id="btnPosto" data-toggle="tab" href="#tabLoginPosto" aria-expanded="false">Posto</a></li>
                    @endif    
                    @if(config('system.acessoParceiro'))
                        <li class=""><a id="btnParceiro" data-toggle="tab" href="#tabLoginParceiro" aria-expanded="false">Parceiro</a></li>
                    @endif
                    @if(config('system.acessoAutoAtendimento'))
                        <li class=""><a id="btnAuto" href="#tabLoginQRcode" data-toggle="tab" aria-expandend="false">QR Code</a></li>
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
                        @if(!$mobile && config('system.acessoPosto'))
                            <div id="tabLoginPosto" class="tab-pane hidden">
                                <div class="panel-body">
                                    @include('auth.includes.formLoginPosto')
                                </div>
                            </div>
                        @endif
                        @if(config('system.acessoParceiro'))
                            <div id="tabLoginParceiro" class="tab-pane hidden">
                                <div class="panel-body">
                                    @include('auth.includes.formLoginParceiro')
                                </div>
                            </div>
                        @endif
                        @if(config('system.acessoAutoAtendimento'))
                            <div id="tabLoginQRcode" class="tab-pane hidden">
                                <div class="panel-body">
                                    @include('auth.includes.formLoginAutoAtendimento')
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container-keyboard hidden-xs" id="areaTeclado">
            @if(config('system.acessoAutoAtendimentoTeclado'))
             
                @include('auth.includes.tecladoAutoAtendimento')

            @endif
            </div>
            
           
        </div>
        
        @include('auth.includes.modalAjudaPaciente')
        
    </div>
    
   <!--  <footer id="footer-login" class="hidden-lg hidden-md" style="background-color: white">
        <div class="pull-right">
            <a href="{{url()}}/sobre" target="_blank">
                {!! Html::image(config('system.experienceLogo'), 'logo_exp', array('title' => 'eXperience - codemed','id'=>'logoRodape','style'=>'margin-right:20px;margin-top:4px;')) !!}
            </a>        
        </div>
    </footer> -->
</body>

@stop

@section('script')
<script type="text/javascript"> 
    $(document).ready(function () {
 
        $('.footer').hide();
        $('#active-keyboard').on('click', function (e) {

            if ($('.container-keyboard').css('display') == 'none' ) {
                $('.container-keyboard').css('display', 'flex')
            } else {
                $('.container-keyboard').css('display', 'none')
            }
           
        })
        $('.nav').on('shown.bs.tab', function (e) {

            var tabAtiva = $(e.target).text();
            switch(tabAtiva) {
                case "Paciente":
                    $('#atendimento').focus();
                    $('#tabLoginPaciente').removeClass('hidden');
                    $('#tabLoginPosto').addClass('hidden');
                    $('#tabLoginMedico').addClass('hidden');
                    $('#tabLoginParceiro').addClass('hidden');
                    $('#tabLoginQRcode').addClass('hidden');
                   
                    if ($('#v').length == 1 && document.getElementById('v').srcObject !== null) {
                        off_camera()
                    }
                    break;
                case "Médico":
                    $('#cr').focus();
                    $('#tabLoginMedico').removeClass('hidden');
                    $('#tabLoginPosto').addClass('hidden');
                    $('#tabLoginPaciente').addClass('hidden');
                    $('#tabLoginParceiro').addClass('hidden');
                    $('#tabLoginQRcode').addClass('hidden');
          
                    if ($('#v').length == 1 && document.getElementById('v').srcObject !== null) {
                        off_camera()
                    }
                    break;
                case "Posto":
                    $('#posto').focus();
                    $('#tabLoginPosto').removeClass('hidden');
                    $('#tabLoginPaciente').addClass('hidden');
                    $('#tabLoginMedico').addClass('hidden');
                    $('#tabLoginParceiro').addClass('hidden');
                    $('#tabLoginQRcode').addClass('hidden');
                   
                    if ($('#v').length == 1 && document.getElementById('v').srcObject !== null) {
                        off_camera()
                    }
                    break;
                case "Parceiro":
                    $('#codparceiro').focus();
                    $('#tabLoginParceiro').removeClass('hidden');
                    $('#tabLoginPosto').addClass('hidden');
                    $('#tabLoginPaciente').addClass('hidden');
                    $('#tabLoginMedico').addClass('hidden');
                    $('#tabLoginQRcode').addClass('hidden');
            
                    if ($('#v').length == 1 && document.getElementById('v').srcObject !== null) {
                        off_camera()
                    }
                    break;
                case "QR Code":
                    $('#QRcode').focus();
                    $('#tabLoginQRcode').removeClass('hidden');
                    $('#tabLoginParceiro').addClass('hidden');
                    $('#tabLoginPosto').addClass('hidden');
                    $('#tabLoginPaciente').addClass('hidden');
                    $('#tabLoginMedico').addClass('hidden');
                    init(!!!$("#v"))
                    break;
            }        
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
            if(e.keyCode == 13) { // enter
                event.preventDefault();
                $('#senha').focus();
            }
        });
        var qtdCaracterAtendimento = parseInt("{{config('system.qtdCaracterPosto')}}") + parseInt("{{config('system.qtdCaracterAtend')}}") 

        $('#footer').hide();
        $('#btnPaciente').click();

        //Funções Teclado Numerico
        var elementoFocado = 'atendimento'; //default preenche atendimento
        $(".alfa").css("opacity", 0.5);
        $(".btnOpc").css("opacity", 1);

        $('#atendimento, #senha').focus(function() {
            elementoFocado = $(':focus')[0].id;

            $("#atendimento").attr('style','background-color:#fff');
            $("#senha").attr('style','background-color:#fff');

            if(elementoFocado == 'atendimento'){
                $(".alfa").css("opacity", 0.5);
                $(".btnOpc").css("opacity", 1);
            }

            if(elementoFocado == 'senha'){
                $(".alfa").css("opacity", 1);
            }
            
            $("#"+elementoFocado).attr('style','background-color:#EFFFE8');
        });

        $('.btnSetNumero').on('click', function(){
            $('#'+elementoFocado).val($('#'+elementoFocado).val()+this.value);                
            tamanhoInput = $('#'+elementoFocado).val();
            if(tamanhoInput.length == 9){
                $('#senha').focus();
            }
            VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
        });

        $('#upperTeclado').on('click', function() {
            $('.btnSetNumero').toggleClass('upper lower');
        });

        $('#btnLimpar').on('click', function() {
            apagar =  $('#'+elementoFocado).val().slice(0, -1);
            document.getElementById(elementoFocado).value = apagar;
            VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
        });

        $('#btnLimparTudo').on('click', function() {
            $('#'+elementoFocado).val('');
        });
    });
</script>
@stop
