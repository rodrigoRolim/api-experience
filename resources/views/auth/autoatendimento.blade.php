@extends('layouts.layoutLogin')

@section('stylesheets')
    <style type="text/css">
        #v{
            width:420px;
            height:400px;            
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        #qr-canvas{
            display:none;
        }
        #qrfile{
            width:320px;
            height:240px;
        }
        #outdiv{
            width: 400px;
        }
        #result{
            margin-top: 20px;
            font-weight: bold;
            font-size: 2em;
        }
        @keyframes blink {

        0% {
          opacity: .2;
        }

        20% {
          opacity: 1;
        }

        100% {
          opacity: .2;
        }
    }

    #result span {
        animation-name: blink;
        animation-duration: 1.4s;
        animation-iteration-count: infinite;
        animation-fill-mode: both;
    }

    #result span:nth-child(2) {
        animation-delay: .2s;
    }

    #result span:nth-child(3) {
        animation-delay: .4s;
    }
    </style>
@stop
<!--         Para liberar acesso a câmera sem pedir permissão no FIREFOX:

            Escrever 'about:config' na barra de endereço do Firefox
            Na caixa de busca, digite 'media.navigator'
            Duplo clique em 'media.navigator.permission.disabled' mudando seu valor para TRUE
            Reinicie o Firefox -->

@section('content')
<body class="animated fadeInDown gray-bg">
    <div class="animated fadeInDown" style="padding-top:20px">
        <div class="row">
            @if (count($errors) == 1)
                <div class="alert alert-danger alert-dismissable">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <h1 class="centralizar">{{config('system.AutoAtendimento')}}</h1><br>

            <div id="outdiv" style="margin:0 auto;"></div>
            <div class="centralizar" id="result"></div>
            <h5 class="centralizar">Posicione o QR Code em frente a Câmera</h5>
            <canvas id="qr-canvas" width="320" height="340"></canvas>

            <div class="text-center" style="padding-top:20px">
                <a href="http://www.codemed.com.br" target="_new">
                    {!! Html::image(config('system.eXperienceLogoHorizontal'), 'logo_exp', array('title' => 'Experience', 'height' => 45)) !!}
                </a>
            </div>

            {!! Form::open(array('url'=>'/auth/autoatendimento','id'=> 'formAutoAtendimento', 'role'=> 'form')) !!}
            	{!! Form::hidden('id','', array('id'=>'id')) !!}
            {!! Form::close() !!}
        </div>
    </div>
</body>
@stop

@section('script')
    <script src="{{ asset('/assets/js/experience/qrcode/llqrcode.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/qrcode/read.js') }}"></script>
    <script type="text/javascript"> 
        $(document).ready(function(){
            load();
            $('#footer').hide();
        });
    </script>
@stop