@extends('layouts.layoutLogin')

@section('stylesheets')
    <style type="text/css">
        #v{
            width:320px;
            height:240px;
        }
        #qr-canvas{
            display:none;
        }
        #qrfile{
            width:320px;
            height:240px;
        }
        #outdiv{
            width: 450px;
        }
    </style>
@stop

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
            <h1 class="centralizar">Mensagem que deve ficar no system.config</h1><br>

            <div id="outdiv" style="margin:0 auto;"></div>
            <div id="result"></div>
            <canvas id="qr-canvas" width="800" height="600"></canvas>

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
        });
    </script>
@stop