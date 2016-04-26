@extends('layouts.layoutBase')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}  
    {!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
@stop

@section('infoHead')
    <div class="feed-element infoUser" style="margin-right: 10px">
        <div class="pull-right media-body">
            <button data-toggle="dropdown" class="btn btn-usuario dropdown-toggle boxLogin">
                <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span> <span class="caret"></span><br>
            </button> 
            <ul class="dropdown-menu pull-right itensInfoUser"> 
                <li class="item">
                    <a href="{{url('/')}}/auth/logout">
                        <i class="fa fa-sign-out"></i> Sair
                    </a>
                </li>                           
            </ul>
        </div>
    </div>
@stop
@section('content')
    <div id="page-wrapper-posto" class="gray-bg">
        <a hred="" id="linkPdf" target="_blank"></a>
        <div class="row-fluid areaPacientePos">
            <div style="padding-left:0px;" class="col-md-6 col-sm-6 col-xs-12">  
                <a href="{{url('')}}/posto" class="btn btn-lg btnVoltar pull-left"><i class="fa fa-arrow-left" style="font-size: 24px;"></i></a>      
                <strong><span id="nome" class="nomePaciente">{{$atendimento->nome}}</span></strong><br>
                <div class="row">
                    <div style="padding-left:0px" class="col-md-3 col-sm-3">
                        <span data-toggle="tooltip" data-placement="bottom" title="Idade"><i class="fa fa-birthday-cake" aria-hidden="true"></i> <span class="idadePaciente">{{$atendimento->idade}}</span></span>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <span  data-toggle="tooltip" data-placement="bottom" title="Data do Atendimento"><i id="iconeAtd" class="fa fa-calendar-check-o"></i>
                        <span id="dataAtendimento">{{$atendimento->data_atd}}</span></span>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <span  data-toggle="tooltip" data-placement="bottom" title="Previsão de Entrega"><i id="iconeAtd" class="fa fa-clock-o"></i>
                        <span id="dataEntrega">{{$atendimento->data_entrega}}</span></span>
                    </div>
                </div>
            </div>
            <div style="margin-top: 5px;" class="col-md-2 col-sm-2 col-xs-6 convAtdPos">
                <span  data-toggle="tooltip" data-placement="bottom" title="ID Atendimento">
                    <i id="iconeAtd" class="fa fa-heartbeat"></i>
                    <span id="atendimento">{{str_pad($atendimento->posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT)}}/{{str_pad($atendimento->atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT)}}</span>
                </span><br>
                <span  data-toggle="tooltip" data-placement="bottom" title="Acomodação">
                    <i class="fa fa-bed"></i>
                    <span id="acomodacao">{{$atendimento->acomodacao != '' ? $atendimento->acomodacao : 'Não Informado'}}</span>
                </span>
            
            </div>
            <div style="margin-top: 5px;" class="col-md-3 col-sm-3">
                <br>
                <span data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"> 
                    <i id="iconeSolic" class="fa fa-user-md"></i>
                    <span id="soliciante">&nbsp;{{$atendimento->nome_solicitante}}</span>
                </span>
            </div>
        </div>
    </div> 
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <span id="msgPendencias"></span> 
            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
                
            </ul>
        </div>
    </div>

    @include('layouts.includes.base.modalDetalhamentoExames')

    @section('statusFooter')
        <span class='statusAtendimentosViewPaciente'></span>
        <span class='statusFinalizados'></span>Finalizados 
        <span class='statusAguardando'></span>Parc. Finalizado
        <span class='statusEmAndamento'></span>Em Andamento 
        <span class='statusPendencias'></span>Existem Pendências
        <span class='statusNaoRealizado'></span>Não Realizado
    @stop
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exames/exames.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            var exames = new ExamesClass();
            var dataResult = exames.get("{{url('/')}}","posto","{{$atendimento->posto}}","{{$atendimento->atendimento}}");
            
            $('.listaExames').html('{!!config("system.messages.loading")!!}');

            $('.ibox').slimScroll({
                height: '76vh',
                railOpacity: 0.4,
                wheelStep: 10,
                size: '12px',
                alwaysVisible: true,
                railVisible: true,
                minwidth: '100%',
                touchScrollStep: 50,
            });

            dataResult.then(function(result){
                var dataMsg = [];
                dataMsg['tipoEntregaInvalido'] = "{!!config('system.messages.exame.tipoEntregaInvalido')!!}";

                $('.listaExames').html('');
                
                $('.listaExames').append(exames.render(result,'{{$atendimento->saldo_devedor}}',dataMsg));
                
                $(".boxExames").click(function(e){
                    var visu = $(e.currentTarget).data('visu');
                    var correl = $(e.currentTarget).data('correl');
                    var posto = $(e.currentTarget).data('posto');
                    var atendimento = $(e.currentTarget).data('atendimento');

                    var dataExameResult = exames.detalheExame("{{url('/')}}","posto",posto,atendimento,correl);

                    $('#modalTitleExames').html('Exames Descrição');
                    $('#modalFooterExames #btn').html('');
                    $('#modalFooterExames #info').html('');

                    $('#modalBodyExames').html('{!!config("system.messages.loadingExame")!!}');
                    $('#modalExames').modal('show');
                    
                    $('.modal-body').slimScroll({
                        height: '55.0vh',
                        railOpacity: 0.4,
                        wheelStep: 10,
                        alwaysVisible: true,
                        minwidth: '100%',
                        touchScrollStep: 50,
                    }); 

                    dataExameResult.then(function(exame){
                        if(exame.data != 'undefined'){
                            render = exames.renderDetalheExame(exame.data);
                            
                            $('#modalTitleExames').html(render.title);
                            $('#modalBodyExames').html(render.table);
                            $('#modalFooterExames #btn').html('<a href="#" id="btnPdfDetalhe" data-correl="'+correl+'" data-posto="'+posto+'" data-atendimento="'+atendimento+'" class="btn btn-danger btnPdf">Gerar PDF</a>');
                        }

                        $('#btnPdfDetalhe').click(function(e){
                            exportPdf(posto,atendimento,correl);
                        });
                    });
                });
                
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-grey',
                });
            });

            function exportPdf(posto,atendimento,correl){
                $('#modalFooterExames #info').html('{!!config("system.messages.loadingExportPdf")!!}');

                var dadosExportacao = {};
                dadosExportacao = [{'posto':posto,'atendimento':atendimento,'correlativos': {correl}}];

                var async = new AsyncClass();
                var asyncExport = async.run("{{url('/')}}/posto/exportarpdf",{"dados" : dadosExportacao},'POST');

                asyncExport.then(function(pdf){
                    $('#modalFooterExames #info').html('');

                    if(pdf == 'false'){
                        $('#modalFooterExames #info').html('{!!config("system.messages.dataSnap.ErroExportar")!!}');
                    }

                    $('#linkPdf').attr('href','http://www.google.com.br');

      
                    // console.log(pdf);
                });

               // var paginaPdf = window.open ('/impressao', '', '');

            }

// $('#btnPdfDetalhe').click(function(e){
//                                    posto = $(e.currentTarget).data('posto');
//                                    atendimento = $(e.currentTarget).data('atendimento');
//                                    correl = $(e.currentTarget).data('correl');

//                                    var dadosExportacao = {};                           
//                                    dadosExportacao = [{'posto':posto,'atendimento':atendimento,'correlativos': {correl}}]; 
//                                    var paginaPdf = window.open ('/impressao', '', '');              

//                                    $.ajax({
//                                     url: '{{url("/")}}/'+tipoAcesso+'/exportarpdf',
//                                     type: 'post',
//                                     data: {"dados" : dadosExportacao},
//                                     success: function(data){   
//                                            if(data != 'false'){
//                                                paginaPdf.location = data;     
//                                            }else{
//                                                paginaPdf.close();
//                                                swal("{!!config('system.messages.dataSnap.ErroExportar')!!}", "Tente novamente mais tarde!", "error");
//                                            }             
//                                       }
//                                    }); 
        });
    </script>
@stop