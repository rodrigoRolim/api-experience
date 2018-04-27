@extends('layouts.layoutBaseLeft')

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
                    @if(Auth::user()['tipoAcesso'] == 'MED' || (Auth::user()['tipoAcesso'] == 'PAC' && Auth::user()['tipoLoginPaciente'] == 'CPF'))
                     <li class="item"><a class="btnShowModal"><i class="fa fa-user"></i> Alterar Senha</a></li>
                    @endif
                    <li class="item"><a href="{{url('/')}}/auth/logout"><i class="fa fa-sign-out"></i> Sair</a></li>
            </ul>
        </div>
    </div>
@stop

@section('left')
    <nav id="menuAtendimentos" class="navbar-default navbar-static-side" role="navigation">
        <div class="topoMenu">
            <strong>Relação de Atendimentos</strong>
        </div>
        <ul class="nav metismenu" id="side-menu">
            @foreach($atendimentos as $key => $atendimento)
                <li class="leftMenu {{ !$key ? 'active' : '' }}">
                    <a href="#" class="btnAtendimento"
                       data-posto="{{$atendimento->posto}}"
                       data-paciente="{{$atendimento->nome}}"
                       data-atendimento="{{$atendimento->atendimento}}"
                       data-solicitante="{{$atendimento->nome_solicitante}}"
                       data-convenio="{{$atendimento->nome_convenio}}"
                       data-mnemonicos="{{$atendimento->mnemonicos}}"
                       data-saldo="{{$atendimento->saldo_devedor}}"
                       data-acesso="{{$user['tipoAcesso']}}">
                        <b class="dataMini">
                            <p class="text-center" style="margin:0px;line-height: 14px; padding: 5px">{{$atendimento->data_atd}}<br></p>
                        </b>
                        <span class="nav-label mnemonicos"><strong>{{ $atendimento->data_atd}}</strong><br>
                            {{str_limit($atendimento->mnemonicos,56)}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@stop

@section('content')
    <div id="page-wrapper" class="gray-bg">
        <div class="row">
            <div class="col-md-1 col-xs-3 col-sm-2">
                @if(Auth::user()['tipoAcesso'] == 'MED')
                    <a href="{{url('/')}}/medico" class="btn pull-left"><i class="fa fa-arrow-left" style="font-size: 24px;"></i></a>
                @endif    
            </div>

            <div class="col-md-3 hidden-xs col-sm-3" style="padding: 8px 0px">
                <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"></i>
                <span id="atendimento"></span>
            </div>

            <div class="col-md-3 col-xs-7 col-sm-6" style="padding: 8px 0px">
                @if(Auth::user()['tipoAcesso'] == 'MED')
                    <i class="fa fa-user" data-toggle="tooltip" data-placement="bottom" title="Nome Paciente"> </i>&nbsp;
                    <span id="paciente"></span>
                @else
                    <i class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"> </i>&nbsp;
                    <span id="solicitante"></span>
                @endif
            </div>

            <div class="col-md-4 hidden-xs hidden-sm" style="padding: 8px 0px">
                <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                <span id="acomodacao">{{$atendimento->acomodacao != '' ? $atendimento->acomodacao : 'Não Informado'}}</span>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-1 text-center" style="padding: 8px 14px 0 0">
                <div class="i-checks boxSelectAll"> </div>
            </div>
        </div>


        <div class="row wrapper border-bottom white-bg page-heading" style="margin-top: 0px; padding-top: 0px">
            <div class="ibox">
                <div id="msgPendencias"></div> 
                <ul class="sortable-list connectList agile-list ui-sortable listaExames" style="padding-top: 0px"></ul>
                    
                @include('layouts.includes.base.modalDetalhamentoExames')

                @if(Auth::user()['tipoAcesso'] == 'MED' || (Auth::user()['tipoAcesso'] == 'PAC' && Auth::user()['tipoLoginPaciente'] == 'CPF'))
                    @include('layouts.includes.base.modalAlterarSenha')
                @endif
        </div>
    </div>

    <div class="footer row-fluid" style="padding-left:6px">
        <div class="col-md-8 col-sm-8 leg" style="padding-left:0px;font-size: 1em;padding-top: 0.7em">
	 		<span class='statusAtendimentosViewPaciente'></span>
	        <span class='statusFinalizados'></span>Finalizados 
	        <span class='statusEmAndamento'></span>Em Processo
	        <span class='statusPendencias'></span>Existem Pendências
	        <span class='statusNaoRealizado'></span>Em Andamento
        </div>  
        <div id='btnPdfPrincipal' class='col-md-4 col-sm-4'>
    		<button id="btnExportar" type='button' class='btn btn-danger pull-right'>Gerar PDF</button>
		</div>
    </div>
</div>
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>   
    <script src="{{ asset('/assets/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exames/exames.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exportarPdf.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
        	$("body").tooltip({ selector: '[data-toggle=tooltip]' });

            var tipoAcesso = '{{Auth::user()['tipoAcesso']}}';
            var auto = '{{Auth::user()['autoAtendimento']}}';
            var url = '{{url('/')}}';

            if(tipoAcesso == 'MED'){
                tipoAcesso = 'medico';
            }

            if(tipoAcesso == 'PAC'){
                tipoAcesso = 'paciente';
            }

            $('.ibox').slimScroll({
                height: '72vh',
                railOpacity: 0.4,
                wheelStep: 10,
                size: '12px',
                alwaysVisible: true,
                railVisible: true,
                minwidth: '100%',
                touchScrollStep: 50,
            });

            $('.modal-body').slimScroll({
                height: '55.0vh',
                railOpacity: 0.4,
                wheelStep: 10,
                alwaysVisible: true,
                minwidth: '100%',
                touchScrollStep: 50,
            }); 

            $('#side-menu').slimScroll({
                height: '75vh',
                railOpacity: 0.4,
                wheelStep: 10,
                alwaysVisible: true,
                minwidth: '100%',
                touchScrollStep: 50,
            });


            $('.btnAtendimento').click(function(e){
                $('#msgPendencias').html('');
                $('#solicitante').html('');
                $('#paciente').html('');
                                
                //Adiciona o loading
                $('.listaExames').html('{!!config("system.messages.loading")!!}');

                var posto = $(e.currentTarget).data('posto');
                var atendimento = $(e.currentTarget).data('atendimento');
                var nomeSolicitante = $(e.currentTarget).data('solicitante');

                var paciente = $(e.currentTarget).data('paciente');
                $('#paciente').html(paciente);

                $('#solicitante').append(nomeSolicitante);

                saldo = $(e.currentTarget).data('saldo');
                
                var exames = new ExamesClass();
                var dataResult = exames.get("{{url('/')}}",tipoAcesso,posto,atendimento);
                var saldoDevedor = false;
                
                //Verifica saldo devedor do atendimento            
                if(saldo > 0){
                    saldoDevedor = true;
                    $('#msgPendencias').html('{{config("system.messages.pacientes.saldoDevedor")}}');
                }
                
                $(document).keyup(function(e) {
                     if (e.keyCode == 27) { //ESC
                        $('#modalExames').modal('hide');
                    }
                $('.boxSelectAll').html('');
                });

                dataResult.then(function(result){
                    var dataMsg = [];
                    dataMsg['tipoEntregaInvalido'] = "{!!config('system.messages.exame.tipoEntregaInvalido')!!}";

                    $('.listaExames').html('');
                    $('#btnPdfPrincipal').hide();
                    $('.listaExames').append(exames.render(result,saldoDevedor,dataMsg));
                    
                    if(!saldoDevedor){
                        $(".boxExames").click(function(e){
                            var visu = $(e.currentTarget).data('visu');
                            var correl = [$(e.currentTarget).data('correl')];
                            var posto = $(e.currentTarget).data('posto');
                            var atendimento = $(e.currentTarget).data('atendimento');

                            var dataExameResult = exames.detalheExame("{{url('/')}}",tipoAcesso,posto,atendimento,correl);

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
                                    var cabecalho = true;
                                    if(auto){
                                        cabecalho = 0;                            
                                    }
                                    var paginaPdf = window.open ('/impressao', '', ''); 
                                    exportPdf(url,tipoAcesso,posto,atendimento,correl,'M',cabecalho,paginaPdf);
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
                }); 
            });

            $('#btnExportar').click(function(e){
                e.preventDefault();
                var checkboxes = $('input.check:checked');
                var posto = $('.checkExames').data('posto');
                var atendimento = $('.checkExames').data('atendimento');
                var cabecalho = true;

                if(auto){
                    cabecalho = 0;                            
                }

                var correl = [];

                checkboxes.each(function(){
                    correl.push($(this).val());
                });
                var paginaPdf = window.open('/impressao', '', ''); 
                exportPdf(url,tipoAcesso,posto,atendimento,correl,'G',cabecalho,paginaPdf);
            });
    
            $('.leftMenu.active a').trigger('click');
        });
    </script>
@stop