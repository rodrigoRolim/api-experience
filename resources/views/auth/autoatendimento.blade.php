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
            <h5 class="centralizar">Não está conseguindo fazer o login? <a href="{{url('/')}}/auth/index">Acesse por aqui</a></h5>
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