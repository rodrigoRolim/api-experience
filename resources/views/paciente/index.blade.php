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
                <li class="item">
                    <a href="{{url('/')}}/auth/logout">
                        <i class="fa fa-sign-out"></i> Sair
                    </a>
                </li>
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
                       data-atendimento="{{$atendimento->atendimento}}"
                       data-solicitante="{{$atendimento->nome_solicitante}}"
                       data-convenio="{{$atendimento->nome_convenio}}"
                       data-mnemonicos="{{$atendimento->mnemonicos}}"
                       data-saldo="{{$atendimento->saldo_devedor}}"
                       data-acesso="{{$user['tipoAcesso']}}">
                        <b class="dataMini">
                            <p class="text-center" style="margin:0px;line-height: 14px">{{ date('d/m',strtotime($atendimento->data_atd))}}<br>
                                {{ date('Y',strtotime($atendimento->data_atd))}}</p>
                        </b>
                        <span class="nav-label mnemonicos"><strong>{{ date('d/m/y',strtotime($atendimento->data_atd))}}</strong><br>
                            {{str_limit($atendimento->mnemonicos,56)}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@stop

@section('content')
<div id="page-wrapper" class="gray-bg">
     <div class="row-fluid infoCliente">
         <div class="col-xs-12 areaPaciente">
             <div class="col-xs-3">
                 <div class="infoAtendimento">
                     <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"> </i>
                     <span id="atendimento"></span>
                 </div>
             </div>
             <div class="col-xs-3">
                 <div class="medicoSolicitante">             
                     <i class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"> </i>
                     &nbsp;<span id="solicitante"></span>
                 </div>
             </div>
                <div class="col-xs-3">
                    <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                   <span id="acomodacao">{{$atendimento->acomodacao != '' ? $atendimento->acomodacao : 'Não Informado'}}</span>
                </div>
        <div class="i-checks allPac boxSelectAll"> </div>
        </div> <!-- fim da div page-wrapper -->

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <span id="msgPendencias"></span> 
	            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
                @include('layouts.includes.base.modalDetalhamentoExames')
                    @if($user['tipoLoginPaciente'] == 'CPF')   
                           @include('layouts.includes.base.modalAlterarSenha')
                    @endif
        </div>
    </div>
    <div class="footer row-fluid" style="padding-left:6px">
            <div class="col-md-8 col-sm-8" style="padding-left:0px">
		 		<span class='statusAtendimentosViewPaciente'></span>
		        <span class='statusFinalizados'></span>Finalizados 
		        <span class='statusAguardando'></span>Parc. Finalizado
		        <span class='statusEmAndamento'></span>Em Andamento 
		        <span class='statusPendencias'></span>Existem Pendências
		        <span class='statusNaoRealizado'></span>Não Realizado
            </div>  
            <div id='btnPdfPrincipal' class='col-md-4 col-sm-4'>
        		<button type='button' class='btn btn-danger pull-right'>Gerar PDF</button>
    		</div>
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
    <script src="{{ asset('/assets/js/experience/utils/strPad.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>
    <script src="{{ asset('/assets/js/experience/exames/exames.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function () {

    	$("body").tooltip({ selector: '[data-toggle=tooltip]' });
    	var exames = new ExamesClass();
		var dataResult = exames.get("{{url('/')}}","paciente","{{$atendimento->posto}}","{{$atendimento->atendimento}}");
        var saldo = '{{$atendimento->saldo_devedor}}';
        var saldoDevedor = false;
        //Verifica saldo devedor do atendimento            
        if(saldo > 0){
            saldoDevedor = true;
            $('#msgPendencias').html('{{config("system.messages.pacientes.saldoDevedor")}}');
        }

        var autoAtendimento = "<?php echo Auth::user()['autoAtendimento'] ?>";
         if(autoAtendimento){
                $('#menuAtendimentos').addClass('hidden');
            }

            $('.btnAtendimento').click(function(e){                
                posto = $(e.currentTarget).data('posto');
                atendimento = $(e.currentTarget).data('atendimento');
                nomeSolicitante = $(e.currentTarget).data('solicitante');
                nomeConvenio = $(e.currentTarget).data('convenio');
                saldo = $(e.currentTarget).data('saldo');       
                mnemonicos = $(e.currentTarget).data('mnemonicos');  
                tipoAcesso = $(e.currentTarget).data('acesso');  

                if(mnemonicos == ""){                    
                    swal("Não foram realizados exames para este atendimento.");
                }

                if(posto != null && atendimento != null){
                    var exames = new ExamesClass();
        			var dataResult = exames.get("{{url('/')}}","paciente",posto,atendimento);
                }	

                $('.boxSelectAll').html('');
            });

            $('.leftMenu.active a').trigger('click');

            $('.ibox').slimScroll({
                height: '69vh',              
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
                height: '55	vh',
                railOpacity: 0.4,
                wheelStep: 10,
                alwaysVisible: true,
                minwidth: '100%',
                touchScrollStep: 50,
            });    

            $(document).keyup(function(e) {
                 if (e.keyCode == 27) { //ESC
                    $('#modalExames').modal('hide');
                }
            });

            dataResult.then(function(result){
                var dataMsg = [];
                dataMsg['tipoEntregaInvalido'] = "{!!config('system.messages.exame.tipoEntregaInvalido')!!}";

                $('.listaExames').html('');
                
                $('.listaExames').append(exames.render(result,saldoDevedor,dataMsg));
                
                if(!saldoDevedor){
                    $(".boxExames").click(function(e){
                        var visu = $(e.currentTarget).data('visu');
                        var correl = $(e.currentTarget).data('correl');
                        var posto = $(e.currentTarget).data('posto');
                        var atendimento = $(e.currentTarget).data('atendimento');

                        var dataExameResult = exames.detalheExame("{{url('/')}}","paciente",posto,atendimento,correl);

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
                                exportPdf(posto,atendimento,correl,'M');
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

                    exportPdf(posto,atendimento,correl,'G');
                });
            }); 



    });

    </script>

@stop