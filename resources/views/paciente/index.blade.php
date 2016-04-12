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
            @if($user['tipoAcesso'] != 'POS')
                {{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;
            @endif
            </button> 
            <ul class="dropdown-menu pull-right itensInfoUser"> 
            @if($user['tipoAcesso'] != 'POS')
                @if(($user['tipoAcesso'] == 'MED') || ($user['tipoLoginPaciente'] != 'ID'))          
                        <li class="item">
                            <a class="btnShowModal">
                                <i class="fa fa-user"></i> Alterar Senha
                            </a>
                        </li>
                @endif
            @endif
                <li class="item">
                    <a href="{{url('/')}}/auth/logout">
                        <i class="fa fa-sign-out"></i> Sair
                    </a>
                </li>                           
            </ul>
        </div>
    </div>
@stop
@if($user['tipoAcesso'] != 'POS')
    @section('left')
        <nav class="navbar-default navbar-static-side" role="navigation">
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
@endif

@section('content')
@if($user['tipoAcesso'] == 'POS')
<div id="page-wrapper-posto" class="gray-bg">
@else
<div id="page-wrapper" class="gray-bg">
@endif
        @if($user['tipoAcesso'] == 'POS')         
    <div class="row-fluid areaPacientePos">
        <div style="padding-left:0px;" class="col-md-6 col-sm-6 col-xs-12">  
            <button type="button" class="btn btn-lg btnVoltar pull-left"><i class="fa fa-arrow-left" style="font-size: 24px;"></i></button>      
            <strong><span id="nome" class="nomePaciente">{{$atendimento->nome}}</span></strong><br>
            <div class="row">
                <div style="padding-left:0px" class="col-md-3 col-sm-3">
                    <i class="fa fa-birthday-cake" aria-hidden="true"></i> <span class="idadePaciente">{{$atendimento->idade}}</span>
                </div>
                <div class="col-md-3 col-sm-3">
                    <i id="iconeAtd" class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"></i>
                    <span id="atendimento">{{str_pad($atendimento->posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT)}}/{{str_pad($atendimento->atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT)}}</span>
                </div>
            </div>
        </div>
        @if($atendimento->acomodacao != '')
            <div style="margin-top: 5px;" class="col-md-3 col-sm-3 col-xs-6 convAtdPos">
                <i id="iconeSolic" class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"></i>
                    <span id="soliciante">{{$atendimento->nome_solicitante}}</span><br>
                <i class="fa fa-bed" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                    <span id="acomodacao">{{$atendimento->acomodacao}}</span>
            </div>
        @else
            <div style="margin-top: 5px;" class="col-md-3 col-sm-3 col-xs-6 convAtdPos">
                <i id="iconeSolic" class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"></i>
                    <span id="soliciante">{{$atendimento->nome_solicitante}}</span><br>
                <i class="fa fa-bed" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                <span id="acomodacao">Não Informado</span>
            </div>
        @endif
            <div class="i-checks all boxSelectAll"> </div>
    </div>
    @endif
    @if($user['tipoAcesso'] != 'POS')    
     <div class="row-fluid infoCliente">
         <div class="col-xs-12 areaPaciente">
             <div class="col-xs-4">
                 <div class="infoAtendimento">
                     <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"> </i>
                     <span id="atendimento"></span>
                 </div>
             </div>
             <div class="col-xs-4">
                 <div class="medicoSolicitante">             
                     <i class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"> </i>
                     &nbsp;<span id="solicitante"></span>
                 </div>
             </div>
             @if($atendimento->acomodacao != '')
                <div class="col-xs-4">
                    <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                    <span id="acomodacao">{{$atendimento->acomodacao}}</span>
                </div>
            @else
                <div class="col-xs-4">
                    <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                    <span id="acomodacao">Não Informado</span>
                </div>
            @endif
     </div> <!-- fim da div page-wrapper -->
    @endif

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <span id="msgPendencias"></span> 
            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
                @include('layouts.includes.base.modalDetalhamentoExames')
                @if($user['tipoAcesso'] != 'POS')
                    @if(($user['tipoAcesso'] == 'MED') || ($user['tipoLoginPaciente'] != 'ID'))   
                           @include('layouts.includes.base.modalAlterarSenha')
                    @endif
                @endif
            </ul>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
             @if($user['tipoAcesso'] != 'POS')
                <div class="col-md-6 txtRodape"></div>  
                <div class="col-md-3 " id="boxRodape"></div>
             @else
                <div class="col-md-8 txtRodape"></div>  
                <div class="col-md-4 " id="boxRodape"></div>
             @endif
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

    <script type="text/javascript">

        $(document).ready(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            $.strPad = function(i,l,s) {
                var o = i.toString();
                if (!s) { s = '0'; }
                while (o.length < l) {
                    o = s + o;
                }
                return o;
            };

            var posto;
            var atendimento;
            var nomeSolicitante;
            var nomeConvenio;
            var mnemonicos;

            var tipoAcesso = "<?php echo Auth::user()['tipoAcesso'] ?>";
            if(tipoAcesso == 'POS'){
                tipoAcesso = 'posto';
                window.tipoAcesso = 'posto';
            }

            if(tipoAcesso == 'posto'){
                var posto = '{{$atendimento->posto}}';
                var atendimento = '{{$atendimento->atendimento}}';      
                var saldo = '{{$atendimento->saldo_devedor}}'; 
                var mnemonicos = '{{$atendimento->mnemonicos}}';

                var controle;           
               
                getExames(posto,atendimento,tipoAcesso);

                $('.btnVoltar').click(function(){
                    window.location.replace("{{url('/')}}/posto");
                 });

            }

            var form = $('#formSenha');
                
            form.validate({
                rules: {
                    senhaAtual: {
                        required: true
                    },
                    novaSenha: {
                        required: true,
                        minlength: 6,
                        maxlength:15
                    },
                    confirmarSenha: {
                        required: true,
                        equalTo: "#novaSenha",
                        minlength: 6,
                        maxlength:15
                    }
                },
            });

            $('.btnAtendimento').click(function(e){                
                posto = $(e.currentTarget).data('posto');
                atendimento = $(e.currentTarget).data('atendimento');
                nomeSolicitante = $(e.currentTarget).data('solicitante');
                nomeConvenio = $(e.currentTarget).data('convenio');
                saldo = $(e.currentTarget).data('saldo');       
                mnemonicos = $(e.currentTarget).data('mnemonicos');  
                tipoAcesso = $(e.currentTarget).data('acesso');  

                switch(tipoAcesso){
                    case 'MED':
                        tipoAcesso = 'medico';
                        break;
                    case 'PAC':
                        tipoAcesso = 'paciente';
                        break;
                    case 'POS':
                        tipoAcesso = 'posto';
                        break;
                }

                window.tipoAcesso = tipoAcesso; //Variavel Global.. Gambi - Para usar no Detalhamento.

                if(mnemonicos == ""){                    
                    swal("Não foram realizados exames para este atendimento.");
                }

                if(posto != null && atendimento != null){
                    getExames(posto,atendimento,tipoAcesso);
                }

                $('.boxSelectAll').html('');
            });

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
                height: '60vh',
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

            $('.leftMenu.active a').trigger('click');

            function verificaSaldoDevedor(saldo){
                if(saldo == null || saldo == 0){
                   return false;
                }
                return true;
            }

            function getExames(posto,atendimento,tipoAcesso){
                //Carregando
                $('.listaExames').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                //Pega os dados via get de exames do atendimento
                $.get( "{{url('/')}}/"+tipoAcesso+"/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    $('#solicitante').html(nomeSolicitante);
                    $('#convenio').html(nomeConvenio);
                    $('#atendimento').html($.strPad(posto, {{config('system.qtdCaracterPosto')}}) + '/' + $.strPad(atendimento, {{config('system.qtdCaracterAtend')}}));
                    $('.listaExames').html('');
                    $('#boxRodape').html('');

                    $.each( result.data, function( index, exame ){                     
                        var sizeBox = 'col-md-6';
                        var conteudo = '';
                        var msg = '';
                        var check = '';
                        var link = '';
                        var visualizacao = 'OK';
                        
                        if(!verificaSaldoDevedor(saldo)){
                            if(exame.class == 'success-element'){                                
                                 if(exame.tipo_entrega == '*'){
                                    $('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');
                                    link = '<a id="btnViewExame" data-toggle="modal" data-target="#modalExames" "data-tipoEntrega="'+exame.tipo_entrega+'">';   

                                    visualizacao = "data-visualizacao='OK'"; 

                                    check = '<div class="i-checks checkExames" data-posto="'+exame.posto+'" data-atendimento="'+exame.atendimento+'"><input type="checkbox" class="check" value="'+exame.correl+'"></div>';                                         
                              }else{
                                msg = '{!!config('system.messages.exame.tipoEntregaInvalido')!!}';
                                exame.class = "success-elementNoHov";
                                check = '';                                
                            }   
                          }
                        }

                         conteudo = link+'<div class="'+sizeBox+' boxExames "'+
                                        'data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+'"" '+visualizacao+' "><li class="'+exame.class+' animated fadeInDownBig">'+check+                                        
                                        '<div class="dadosExames">' +                                        
                                            '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+
                                            '<br>'+exame.msg+'<br><span class="msgExameTipoEntrega">'+msg+'</span>'+
                                            '<div class="postoRealizante"><i class="fa fa-hospital-o data-toggle="tooltip" data-placement="top" title="Posto Realizante""></i> '+exame.nome_posto_realizante+'</div>'+'</li></div>';

                        $('.listaExames').append(conteudo);
                    });

                     $('.boxExames').click(function(e){ 
                            if($(e.currentTarget).data('visualizacao') == 'OK'){
                                var dadosExames = $(e.currentTarget).data();                                             
                                getDescricaoExame(dadosExames,window.tipoAcesso);                 
                            }
                            else{
                                return false;
                            }
                    });     

                    function getDescricaoExame(dadosExames){                       
                        
                        $('.modal-title').html('');   
                        $('#tabelaDetalhes').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   
                        $('#rodapeDetalhe').html('');    

                        $.ajax({
                            url : '{{url("/")}}/'+tipoAcesso+'/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
                            type: 'GET',                           
                            success:function(result){                                
                                if(result.data == null){
                                    $('#modalExames').modal('hide');
                                    swal("Erro ao carregar descrição do exame..", "Não há resultados disponíveis para visualização.", "error");                                    
                                    return false;
                                }
                                var descricao = result.data;
                                var analitos = result.data.ANALITOS;
                                var conteudo = '';                                                          
                                
                                $('.modal-title').append(descricao.PROCEDIMENTO);
                                $('#tabelaDetalhes').html(''); 
                               
                                $('#dvPdfDetalhe').html('<a href="#" id="btnPdfDetalhe" data-correl="'+dadosExames.correl+'" data-posto="'+dadosExames.posto+'" data-atendimento="'+dadosExames.atendimento+'" class="btn btn-danger btnPdf">Gerar PDF</a>');  

                                $.each( analitos, function( index ){

                                    switch(analitos[index].UNIDADE) {
                                        case 'NULL':
                                            analitos[index].UNIDADE = '';
                                            break;                                                                      
                                    }       

                                    var valorAnalito = analitos[index].VALOR;
                                    if(!isNaN(valorAnalito)){
                                        var valorAnalito = Math.round(analitos[index].VALOR);
                                        valorAnalito = valorAnalito.toFixed(analitos[index].DECIMAIS);
                                    }

                                   conteudo =   '<tr>'+
                                                    '<td class =descricaoExames">'+
                                                 '<td class=" analitos">'+
                                                    ''+analitos[index].ANALITO+'</td></div>'+
                                                 '<td class="valoresAnalitos">'+
                                                    '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong>'+
                                                 '</td></tr>';

                                    $('#tabelaDetalhes').append(conteudo);

                                }); 

                                    $('#tabelaDetalhes').append('<tr><td id="finalDetalhamento" colspan="3"> Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+' - '+
                                    descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Data e Hora da Coleta: '+descricao.DATA_COLETA+'</td></tr>')


                                $('#btnPdfDetalhe').click(function(e){
                                    posto = $(e.currentTarget).data('posto');
                                    atendimento = $(e.currentTarget).data('atendimento');
                                    correl = $(e.currentTarget).data('correl');

                                    var dadosExportacao = {};                           
                                    dadosExportacao = [{'posto':posto,'atendimento':atendimento,'correlativos': {correl}}]; 
                                    var paginaPdf = window.open ('/impressao', '', '');              

                                    $.ajax({ 
                                     url: '{{url("/")}}/'+tipoAcesso+'/exportarpdf',
                                     type: 'post',
                                     data: {"dados" : dadosExportacao},
                                     success: function(data){   
                                            if(data != 'false'){
                                                paginaPdf.location = data;     
                                            }else{
                                                paginaPdf.close();
                                                swal("Erro ao exportar resultados para PDF", "Tente novamente mais tarde!", "error");
                                            }             
                                       }
                            });    


                                });    

                                if(result.data.length == 0){
                                    $('.modal-body').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                $('.modal-body').html('');
                                $('.modal-body').append('<div class="text-center alert alert-danger animated fadeIn erroDescricao"><i class="fa fa-exclamation-circle fa-5x"></i><h2>Erro ao carregar Descrição do Exame.</h2></div>');
                            }
                        });
                    } 

                    $('#boxRodape').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');             

                    var checkAll = $('input.checkAll');
                    var checkboxes = $('input.check');

                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-grey',
                    });

                    if(checkboxes.filter(':checked').length == 0) { 
                        $('.btnPdf').hide();
                    }

                    //verifica se o usuario tem saldo devedor
                    if(!verificaSaldoDevedor(saldo)){
                        $('#msgPendencias').html('');
                        $('input.checkAll').on('ifChecked ifUnchecked', function(event) {
                            if (event.type == 'ifChecked') {
                                checkboxes.iCheck('check');
                                $('.btnPdf').show();
                            } else {
                                checkboxes.iCheck('uncheck');
                                $('.btnPdf').hide();
                            }
                        });

                        // Faz o controle do botão de gerar PDF. (Se houver ao menos um selecionado, o botão é habilitado.)
                        $('input.check').on('ifChanged', function(event){
                            if(checkboxes.filter(':checked').length == 0) { 
                                $('.btnPdf').hide();
                            }else{                               
                                $('.btnPdf').show();
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

                        $('.checkAll').trigger('ifChecked');

                         $('.btnPdf').click(function(e){    
                             var checkboxes = $('input.check:checked');                                  
                             var posto = $('.checkExames').data('posto');
                             var atendimento = $('.checkExames').data('atendimento');

                             var correl = [];
                             checkboxes.each(function () {
                                    correl.push($(this).val());
                                });   

                             var dadosExame = {};                           
                             dadosExame = [{'posto':posto,'atendimento':atendimento,'correlativos':correl}];
                             var paginaPdf = window.open ('{{url("/")}}/impressao', '', '');       

                             $.ajax({
                                 url: '{{url("/")}}/paciente/exportarpdf',
                                 type: 'post',
                                 data: {"dados" : dadosExame},
                                 success: function(data){   
                                     if(data != 'false'){                                        
                                        paginaPdf.location = data;    
                                    }else{
                                        paginaPdf.close();
                                        swal("Erro ao exportar resultados para PDF", "Tente novamente mais tarde.!", "error");
                                    }                      
                                 }

                                });          
                        });   

                    }else{
                        $('#msgPendencias').html('<h5 class="text-danger">{!!config('system.messages.pacientes.saldoDevedor')!!}</h3>');
                    }
                }, "json" );
            }
        });         
            $(".txtRodape").append("<span class='statusAtendimentosViewPaciente'></span>");            
            $(".statusAtendimentosViewPaciente").append(" <span class='statusFinalizados'></span>Finalizados <span class='statusAguardando'></span>Parc. Finalizado");
            $(".statusAtendimentosViewPaciente").append("<span class='statusEmAndamento'></span>Em Andamento <span class='statusPendencias'></span>Existem Pendências");
            if(window.tipoAcesso == 'posto'){
                $(".statusAtendimentosViewPaciente").append("<div id='legendasRodape'><i class='fa fa-heartbeat'></i> Posto/Atendimento &nbsp;|&nbsp;");
                $(".statusAtendimentosViewPaciente").append("<i class='fa fa-credit-card'></i> Acomodacao | ");
                $(".statusAtendimentosViewPaciente").append("<i class='fa fa-user-md'></i> Solicitante</div>");                
            }

    </script>
@stop