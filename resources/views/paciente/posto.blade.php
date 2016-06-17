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
            <li class="item imprimirTimbrado"><input id="checkTimbrado" type="checkbox"></i>&nbsp; Imprimir Timbrado</li> 
            <li style="border-bottom:1px solid #efefef; margin-top:8px"></li>    
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
                <strong><span id="nome" class="nomePaciente">{{mb_strimwidth($atendimento->nome,0,46,'...')}}</span></strong><br>
                <div class="row">
                    <div style="padding-left:0px" class="col-md-3 col-sm-3">
                        <span data-toggle="tooltip" data-placement="bottom" title="Idade"><i class="fa fa-birthday-cake" aria-hidden="true"></i> <span class="idadePaciente">{{$atendimento->idade}}</span></span>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <span  data-toggle="tooltip" data-placement="bottom" title="Data do Atendimento"><i id="iconeAtd" class="fa fa-calendar-check-o"></i>
                        <span id="dataAtendimento">{{$atendimento->data_atd}}</span></span>
                    </div>
                    @if($atendimento->data_entrega != '')
                        <div class="col-md-3 col-sm-3">
                            <span  data-toggle="tooltip" data-placement="bottom" title="Previsão de Entrega"><i id="iconeAtd" class="fa fa-clock-o"></i>
                            <span id="dataEntrega">{{$atendimento->data_entrega}}</span></span>
                        </div>
                    @endif
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
                    <span id="solicitante">&nbsp;{{$atendimento->nome_solicitante}}</span>
                </span>
            </div>
            <div class="col-md-1 col-sm-1">
                <div style="margin-right:13px;" id="checkAll" class="i-checks all boxSelectAll"> </div>
            </div>
        </div>
    </div> 
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <span id="msgPendencias" class="col-md-12"></span> 
            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
                
            </ul>
        </div>
    </div>

    @include('layouts.includes.base.modalDetalhamentoExames')

    @section('statusFooter')
    <div style='padding-left:0px;' class='col-md-6 col-sm-6'>
        <span class='statusAtendimentosViewPaciente'></span>
        <span class='statusFinalizados'></span>Finalizados 
        <span class='statusEmAndamento'></span>Em Processo
        <span class='statusPendencias'></span>Existem Pendências
        <span class='statusNaoRealizado'></span>Em Andamento
    </div>
    <div id='btnPdfPrincipal' class='col-md-6 col-sm-6'>
        <button type='button' class='btn btn-danger pull-right'>Gerar PDF</button>
    </div>
    @stop
@stop
@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exames/exames.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exportarPdf.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/js-cookie/js.cookie.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            var tipoAcesso = '{{Auth::user()['tipoAcesso']}}';
            var url = '{{url('/')}}';
            if(Cookies.get('cabecalho') == 'true'){
                $('#checkTimbrado').iCheck('check');                
            }

            $('#checkTimbrado').on('ifChecked', function (event){
                Cookies.set('cabecalho',true);  
            });

            $('#checkTimbrado').on('ifUnchecked', function (event){
                Cookies.set('cabecalho',false);    
            });

            if(tipoAcesso == 'POS'){
                tipoAcesso = 'posto';
            }

            var exames = new ExamesClass();
            var dataResult = exames.get("{{url('/')}}","posto","{{$atendimento->posto}}","{{$atendimento->atendimento}}");
            var saldo = '{{$atendimento->saldo_devedor}}';
            var saldoDevedor = false;

            $('#btnPdfPrincipal').hide();

            //Verifica saldo devedor do atendimento            
            if(saldo > 0){
                saldoDevedor = true;
                $('#msgPendencias').html('{{config("system.messages.pacientes.saldoDevedor")}}');
            }

            //Adiciona o loading
            $('.listaExames').html('{!!config("system.messages.loading")!!}');

            //Adiciona o slimScroll na lista de exames
            $('.ibox').slimScroll({
                height: '71vh',
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
                
                $('.listaExames').append(exames.render(result,saldoDevedor,dataMsg));
                
                if(!saldoDevedor){
                    $(".boxExames").click(function(e){
                        var visu = $(e.currentTarget).data('visu');
                        var correl = [$(e.currentTarget).data('correl')];
                        var posto = $(e.currentTarget).data('posto');
                        var atendimento = $(e.currentTarget).data('atendimento');

                        var dataExameResult = exames.detalheExame("{{url('/')}}","posto",posto,atendimento,correl);

                        $('#modalTitleExames').html('Exames Descrição');
                        $('#modalFooterExames #btn').html('');
                        $('#modalFooterExames #info').html('');

                        $('#modalBodyExames').html('{!!config("system.messages.loadingExame")!!}');

                        if(visu){
                            $('#modalExames').modal('show');                        
                        }
                        
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
                                render = exames.renderDetalheExame(exame.data,saldo);
                                
                                $('#modalTitleExames').html(render.title);
                                $('#modalBodyExames').html(render.table);
                                $('#modalFooterExames #btn').html('<a href="#" id="btnPdfDetalhe" data-correl="'+correl+'" data-posto="'+posto+'" data-atendimento="'+atendimento+'" class="btn btn-danger btnPdf">Gerar PDF</a>');
                            }

                            $('#btnPdfDetalhe').click(function(e){                               
                                var paginaPdf = window.open ('/impressao', '', ''); 
                                exportPdf(url,tipoAcesso,posto,atendimento,correl,'M',Cookies.get('cabecalho'),paginaPdf);
                            });
                        });
                    });
                }
                
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-grey',
                });

                if(!saldoDevedor){
                    var checkAll = $('input.checkAll');
                    var checkboxes = $('input.check');
                    $('input.checkAll').on('ifChecked ifUnchecked', function(event){
                        //Habilitar o checkbox de seleção de exames para impressao
                        if (event.type == 'ifChecked'){
                           checkboxes.iCheck('check');
                           $('#btnPdfPrincipal').show();                          
                        }else{
                           checkboxes.iCheck('uncheck');
                           $('#btnPdfPrincipal').hide();
                        }
                    });

                    $('input.check').on('ifChanged',function(event){
                        var checkboxes = $('input.check');
                        $('#btnPdfPrincipal').hide();

                        if(checkboxes.filter(':checked').length != 0){
                            $('#btnPdfPrincipal').show();
                            checkAll.iCheck('update');
                        }
                    });


                    $('input.check').on('ifChanged', function(event){
                       if(checkboxes.filter(':checked').length == checkboxes.length) {
                           checkAll.prop('checked', 'checked');
                       } else {
                           checkAll.removeProp('checked');
                       }
                       checkAll.iCheck('update');
                   });
                }

                $('.checkAll').trigger('ifChecked');

                $('#btnPdfPrincipal').click(function(e){                    
                    var checkboxes = $('input.check:checked');
                    var posto = $('.checkExames').data('posto');
                    var atendimento = $('.checkExames').data('atendimento');

                    var correl = [];

                    checkboxes.each(function(){
                        correl.push($(this).val());
                    });
                    var paginaPdf = window.open ('/impressao', '', ''); 
                    exportPdf(url,tipoAcesso,posto,atendimento,correl,'G',Cookies.get('cabecalho'),paginaPdf);
                });
           });


        });
    </script>
@stop