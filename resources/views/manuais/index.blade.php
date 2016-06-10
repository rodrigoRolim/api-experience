@extends('layouts.layoutLogin')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}    
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}

    <style type="text/css">
        .i-checks{
            margin-bottom: 10px;
        }
                .corPadrao{
          -vendor-animation-duration: 8s;
          -vendor-animation-delay: 5s;
          -vendor-animation-iteration-count: infinite;
        }
    </style>
@stop

@section('content')
    <body class="gray-bg">
        <div class="container">
            <div class="boxCenter">
                <div id="dvFiltro">
                    <h2 class="centralizar" id="infoFiltro" style="padding-top:5px;margin-bottom:15px">Manual do procedimento/exame</h2>
                    <div class="col-md-12 corPadrao animated fadeInUp">
                        <form id="formPosto">                           
                            <div class="input-group m-b inputBuscaPaciente">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" id="buscaProcedimento" placeholder="Ex: Gli, Glicemia, Hemograma" class="form-control">
                            </div> 
                        </form>
                    </div>
                </div>
                <div id="manual">
                    <div class="wrapper wrapper-content">
                        <div class="ibox-content">
                            <div id="carregando"></div>
                            <ul class="sortable-list connectList agile-list ui-sortable" id="manualProc"></ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </body>
@stop

@section('script')
<script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#body').attr('style','padding-top:0px');
        $('.corPadrao').attr('style','padding:10px');

        
        $('#dvFiltro').attr('style','padding-top:26vh');
        $('.boxCenter').attr('style','min-height:90vh');

        $('#buscaProcedimento').keyup(function(e){
            $('.corPadrao').addClass('animated fadeInUp');
            $('#carregando').html('<h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   

            var url = '{{url('/')}}';

            var data = $(this).val() + '%';
            data = data.toUpperCase();

            $.ajax({
                url : url+'/manuais/procedimentos',
                type: 'POST',
                data: {input:data},
                success:function(result){
                    procedimentos = result.data;
                    $('#manualProc').html('');    
                    for(var i = 0; i <= procedimentos.length; i++){
                        $('#manualProc').append('<li>"'+procedimentos[i].mnemonico+' "'+procedimentos[i].procedimento+'"  "</li>');                          
                    }   
                },
                error: function(jqXHR, textStatus, errorThrown){
                    var msg = jqXHR.responseText;
                    msg = JSON.parse(msg);
                }
            });    

            $('#carregando').html('');
            $('#infoFiltro').remove();
            $('#dvFiltro').attr('style','min-height:0px');
        });

         $('#manual').slimScroll({
            height: '80vh',
            width:'100%',
            size: '12px',
            railVisible: true,
            background: '#ADADA',
            railOpacity: 0.4,
            wheelStep: 10,
            minwidth: '100%',
            allowPageScroll: true,
            touchScrollStep: 50,
            alwaysVisible: false
        });
     

    });
</script>
@stop