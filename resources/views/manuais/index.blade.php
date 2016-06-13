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
                    <h2 class="centralizar" id="infoFiltro" style="padding-top:5px;margin-bottom:15px">Manual de procedimentos/exames</h2>
                    <div class="col-md-12 corPadrao animated fadeInUp">
                        <div class="input-group m-b inputBuscaPaciente">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" id="buscaProcedimento" placeholder="Digite o nome do exame, Ex. Gli ou Glicemia" class="form-control">
                        </div> 
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
    <div class="modal fade" id="modalManual" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title" id="modalTitle"></h2>
                </div>
                <div class="modal-body" id="modalBody">
                    
                </div>
            </div>
        </div>
    </div>
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
            if(e.which != 13){
                if($('#buscaProcedimento').val() != ''){
                    $('.corPadrao').addClass('animated fadeInUp');

                    var data = $(this).val();
                    data = data.toUpperCase();

                    $('#manualProc').html('<h2 class="textoTamanho" style="margin-top:25vh"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');

                    $.get("{{url('/')}}/manuais/procedimentos/"+data,function(result){
                        $('#manualProc').html('');
            
                        procedimentos = result.data;

                        var html = '';

                        for(var i=0;i<procedimentos.length;i++){
                            var tipoColeta = '';

                            if(procedimentos[i].tipo_coleta == 'CR'){
                                tipoColeta = 'Esse exame deve ser coletado no laboratório';
                            }

                            html += '<li data-exame="'+procedimentos[i].procedimento+'" data-mnemonico="'+procedimentos[i].mnemonico+'" class="col-sm-12 boxManuais success-element listManuaisMobile">';
                            html += '<div class="no-padding col-md-12 col-sm-6 col-xs-12">';
                            html +=     '<div class="no-padding col-md-5">';
                            html +=         '<strong>'+procedimentos[i].procedimento+'</strong>';
                            html +=     '</div>';
                            html +=     '<div class="no-padding col-md-3">';
                            html +=         '<span data-toggle="tooltip" data-placement="bottom" title="Mnemonico"><i class="fa fa-flask"></i> '+procedimentos[i].mnemonico+'</span>'
                            html +=     '</div>';
                            html +=     '<div class="no-padding col-md-4">';
                            html +=         '<span data-toggle="tooltip" data-placement="bottom" title="Setor"><i class="fa fa-home"></i> '+procedimentos[i].nome_setor+'</span>'
                            html +=     '</div>';
                            html += '</div>';
                            html += '<div class="no-padding col-md-12 col-sm-6 col-xs-12">';
                            html +=     '<div class="no-padding col-md-3">';
                            html +=         '<span data-toggle="tooltip" data-placement="bottom" title="Matérial"> Matérial: </span>'+procedimentos[i].material
                            html +=     '</div>';
                            html +=     '<div class="no-padding col-md-5">';
                            html +=         '<span data-toggle="tooltip" data-placement="bottom" title="Observação"><i class="fa fa-info-cicle"></i> '+tipoColeta+'</span>';
                            html +=     '</div>';

                            if(procedimentos[i].hora_coleta != null){
                                html +=     '<div class="no-padding col-md-4">';
                                html +=         '<span style="color:#FF0000" data-toggle="tooltip" data-placement="bottom" title="Hora da coleta/recebimento"><i class="fa fa-clocl-o"></i>  Exame pode ser coletado/recebido até as '+procedimentos[i].hora_coleta+'</span>';
                                html +=     '</div>';
                            }

                            html += '</div>';
                            html += '</li>';
                        }

                        if(procedimentos.length == 0){
                            html = '<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>';
                        }
                        
                        $('#manualProc').html(html);

                        $(".boxManuais").click(function(e){
                            var mnemonico = $(e.currentTarget).data('mnemonico');
                            var exame = $(e.currentTarget).data('exame');

                            $.ajax({
                                url : "{{url('/')}}/manuais/preparo/"+mnemonico,
                                type: 'GET',
                                success:function(result){
                                    var body = '';

                                    if(result.data == ''){
                                        body = '<h2 class="textoTamanho" style="padding-top:20px;padding-bottom:30px">Exame sem preparo definido pelo laboratório</h2>';
                                    }else{
                                        body = result.data;
                                        
                                        $('#modalBody').slimScroll({
                                            height: '70.0vh',
                                            railOpacity: 0.4,
                                            wheelStep: 10,
                                            alwaysVisible: true,
                                            minwidth: '90vh',
                                            touchScrollStep: 50,
                                        });
                                    }

                                    $('#modalTitle').html(exame);
                                    $('#modalBody').html(body);

                                    $('#modalManual').modal('show');

                                },
                            });
                        });
                    });

                    $('#infoFiltro').remove();
                    $('#dvFiltro').attr('style','min-height:0px');
                }

            }

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