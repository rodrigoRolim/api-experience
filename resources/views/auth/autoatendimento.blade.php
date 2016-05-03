@extends('layouts.layoutLogin')

@section('stylesheets')
    {!! Html::style('/assets/css/autoatendimento.css') !!}
@stop
<!--         Para liberar acesso a câmera sem pedir permissão no FIREFOX:

            Escrever 'about:config' na barra de endereço do Firefox
            Na caixa de busca, digite 'media.navigator'
            Duplo clique em 'media.navigator.permission.disabled' mudando seu valor para TRUE
            Reinicie o Firefox -->

@section('content')
<body class="animated fadeInDown gray-bg">
    <div class="animated fadeInDown" style="padding:0px !important">
        <div class="row">
            @if ($keyboard == 0)
                <div id="outdiv" style="margin:0 auto;"></div>
                <div class="centralizar" id="result"></div>                    
                <div class="centralizar">
                    @if (count($errors) == 1)
                        <div class="alert alert-danger alert-dismissable">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <h5>Posicione o QR Code em frente a Câmera</h5>
                    <h5>Não está conseguindo fazer o login?</h5>
                    <a class="btn btn-primary" href="{{url('/')}}/auth/autoatendimento/1">Pressione aqui</a>
                </div>
                <canvas id="qr-canvas" width="320" height="340"></canvas>

                <div class="text-center" style="padding-top:20px"><br>
                    <a href="http://www.codemed.com.br" target="_new">
                        {!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_exp', array('title' => 'Experience', 'height' => 45)) !!}
                    </a>
                </div>

                {!! Form::open(array('url'=>'/auth/autoatendimento','id'=> 'formAutoAtendimento', 'role'=> 'form')) !!}
                	{!! Form::hidden('id','', array('id'=>'id')) !!}
                {!! Form::close() !!}
            @endif

            @if($keyboard == 1)
                <div class="loginColumns animated fadeInDown" style="padding-top:0px">
                    <div class="row">
                        <div id="infoExperience" class="col-md-6">
                            <h2>
                                <span class="text-navy">{!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_exp', array('title' => 'eXperience - codemed', 'style'=>'height: 80px;')) !!}</span>
                                {!!config('system.loginText.subTitle')!!}
                            </h2>
                            {!!config('system.loginText.description')!!}
                        </div>
                        <div id="areaLogin" class="col-md-6">
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
                                        <li class=""><a id="btnPaciente" data-toggle="tab" href="#tabLoginPaciente" aria-expanded="true">Paciente</a></li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    @if(config('system.acessoPaciente'))
                                        <div id="tabLoginPaciente" class="tab-pane ">
                                            <div class="panel-body">
                                                @include('auth.includes.formLoginPacienteAutoAtendimento')
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-offset-3">
                    @if(config('system.acessoAutoAtendimentoTeclado') == TRUE)
                        <div id="areaTeclado" style="margin-top:30px;">
                            @include('auth.includes.tecladoAutoAtendimento')
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
@stop

@section('script')
    <script src="{{ asset('/assets/js/experience/qrcode/llqrcode.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/qrcode/read.js') }}"></script>
    <script type="text/javascript"> 
        $(document).ready(function(){
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

            @if($keyboard == 0)
                load();
            @endif
        });
    </script>
@stop