@extends('layouts.layoutBaseLeft')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
@show

@section('infoHead')
    <div class="feed-element pull-right infoUser">
        <div class="media-body">
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
    <div class="row-fluid areaPacientePos">
        <div class="col-md-6 col-sm-6 col-xs-12">            
            <button type="button" class="btn btn-lg btnVoltar pull-left"><i class="fa fa-arrow-left" style="font-size: 24px;"></i></button>
            </button>
            <strong><span id="nome" class="nomePaciente">{{$atendimento->nome}}</span></strong><br>
            <div class="idadePaciente">{{$atendimento->idade}}</div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-5 postoAtdPos">
            <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"></i>
            <span id="atendimento">{{str_pad($atendimento->posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT)}}/{{str_pad($atendimento->atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT)}}</span>
        </div>
        @if($atendimento->acomodacao != '')
            <div class="col-md-2 col-sm-2 col-xs-6 convAtdPos">
                <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                <span id="convenio">{{$atendimento->acomodacao}}</span>
            </div>
        @else
            <div class="col-md-2 col-sm-2 col-xs-6 convAtdPos">
                <i class="fa fa-hospital-o" data-toggle="tooltip" data-placement="bottom" title="Acomodação"></i>
                <span id="convenio">Não Informado</span>
            </div>
        @endif
        <div class="col-md-2 col-sm-2 col-xs-6 convAtdPos">
            <i class="fa fa-user-md" data-toggle="tooltip" data-placement="bottom" title="Médico Solicitante"></i>
            <span id="soliciante">{{$atendimento->nome_solicitante}}</span>
        </div>
    </div>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <div class="row">
                <div class="i-checks all boxSelectAll"> </div>
            </div>       
            <span id="msgPendencias"></span> 
            <ul class="sortable-list connectList agile-list ui-sortable listaExames">  </ul>
              <div class="modal fade" id="modalExames" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2 class="modal-title">Exames Descrição</h2>
                    </div>
                      <div class="modal-body">   
                        <table id="tabelaDetalhes" class="table table-striped"></table>                   
                      </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div id="rodapeDetalhe" class="col-lg-10 col-md-10 col-sm-10"></div>
                            <div id="dvPdfDetalhe" class="col-lg-2 col-md-2 col-sm-2"></div>
                        </div>
                    </div>
                  </div>                  
                </div>
              </div>
        </div>          
    </div>  
</div>
<div class="footer">
    <div class='container'>
        <div class="col-md-12 col-sm-12" style="padding-left:0px;">                
            <div class="col-md-8 col-sm-6 txtRodapePostoPac">    </div>  
            <div class="col-md-4 col-sm-6" id="boxRodapePostoPac">    </div>
        </div>
    </div>  
</div>
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>      
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>    
    <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script> 

    <script type="text/javascript">
        $(document).ready(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });  
            
            var posto = {{$atendimento->posto}};
            var atendimento = {{$atendimento->atendimento}};      
            var saldo = '{{$atendimento->saldo_devedor}}'; 
            var mnemonicos = '{{$atendimento->mnemonicos}}';
            var sexo = '{{$atendimento->sexo}}';

            var controle;           
           
            getExames(posto,atendimento);

            $('.idadePaciente').append('<i class="pull-left '+((sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> <span id="idade"></span>');
                $('#idade').html(idade);

            $('.btnAtendimento').hide(); 
            $('.btnAtendimento').trigger('click');         
            $('.navbar-static-side').remove();   

            $('.ibox').slimScroll({
                height: 'auto',
                railOpacity: 0.4,
                railVisible: true,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
                alwaysVisible: true
            });   

            $('.modal-body').slimScroll({
                height: '55.0vh',
                railOpacity: 0.4,
                railVisible: true,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
                alwaysVisible: true
            }); 

            $('#modalExames').modal('hide');

            $(document).keyup(function(e) {
                 if (e.keyCode == 27) { //ESC
                    $('#modalExames').modal('hide');
                }
            });

            $('.btnVoltar').click(function(){
                window.location.replace("{{url('/')}}/posto");
            });

            function verificaSaldoDevedor(saldo){
                if(saldo == null || saldo == 0){
                   return false;
                }
                return true;
            }

            $('.selectPosto').change(function(e) {
               alert( $('.search-choice').text() );
            });

            function getExames(posto,atendimento){
                //Carregando
                $('.listaExames').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');

                //Pega os dados via get de exames do atendimento
                $.get( "{{url('/')}}/posto/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    
                    $('.listaExames').html('');
                    $('#boxRodapePostoPac').html('');

                    $.each( result.data, function( index, exame ){
                        var sizeBox = 'col-md-6';
                        var conteudo = '';
                        var msg = '';
                        var check = '';
                        var link = '';
                        var visualizacao = '';
                        

                        if(!verificaSaldoDevedor(saldo)){
                            if(exame.class == 'success-element'){                                
                                if(exame.tipo_entrega == '*'){
                                    $('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');
                                    link = '<a id="btnViewExame" data-target="#modalExames" "data-tipoEntrega="'+exame.tipo_entrega+'">'; 

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
                                        'data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+' "'+visualizacao+'""><li class="'+exame.class+' animated fadeInDownBig">'+check+
                                        '<div class="dadosExames">' +
                                            '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+
                                            '<br>'+exame.msg+'<br><span class="msgExameTipoEntrega">'+msg+'</span>'+
                                            '<div class="postoRealizante"><i class="fa fa-hospital-o data-toggle="tooltip" data-placement="top" title="Posto Realizante""></i> '+exame.nome_posto_realizante+'</div></li></div>';

                        conteudo += ((link != '') ? '</a>' : '');
                        $('.listaExames').append(conteudo);
                    });

                    $('.boxExames').click(function(e){
                            if($(e.currentTarget).data('visualizacao') == 'OK'){
                                var dadosExames = $(e.currentTarget).data();                                               
                                getDescricaoExame(dadosExames);                 
                            }
                            else{
                                return false;
                            }
                    });   

                    function getDescricaoExame(dadosExames){                        
                        $('#modalExames').modal('show');
                        $('.modal-title').html('');   
                        $('#tabelaDetalhes').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   
                        $('#rodapeDetalhe').html('');    

                        $.ajax({
                            url : '{{url("/")}}/posto/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
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
                                $('#rodapeDetalhe').append('Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+' - '+
                                    descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Data e Hora da Coleta: '+descricao.DATA_COLETA);
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
                                                    ''+analitos[index].ANALITO+'</div>'+
                                                 '<td class="valoresAnalitos">'+
                                                    '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong>'+
                                                 '</tr>';

                                    $('#tabelaDetalhes').append(conteudo);

                                }); 


                                $('#btnPdfDetalhe').click(function(e){
                                    posto = $(e.currentTarget).data('posto');
                                    atendimento = $(e.currentTarget).data('atendimento');
                                    correl = $(e.currentTarget).data('correl');

                                    var dadosExame = {};                           
                                    dadosExame = [{'posto':posto,'atendimento':atendimento,'correlativos':correl}]; 
                                    var paginaPdf = window.open ('/impressao', '', '');              

                                    $.ajax({ 
                                     url: '{{url("/")}}/posto/exportarpdf',
                                     type: 'post',
                                     data: {"dados" : dadosExame},
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

                    $('#boxRodapePostoPac').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');   
                      
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
                             var paginaPdf = window.open ('/impressao', '', '');              

                            $.ajax({ // Faz verificação de dados do cliente dentro do formulario(modal) de cadastrar senha.
                             url: '{{url("/")}}/posto/exportarpdf',
                             type: 'post',
                             data: {"dados" : dadosExame},
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

                    }else{
                        $('#msgPendencias').html('<h5 class="text-danger">{!!config('system.messages.pacientes.saldoDevedor')!!}</h3>');
                        $('#boxRodapePostoPac').css("margin-right", "0px");
                    }
                }, "json" );
            }
        });
            $(".txtRodapePostoPac").append("<span class='statusAtendimentosViewPaciente'></span>");            
            $(".statusAtendimentosViewPaciente").append(" <span class='statusFinalizados'></span>&nbsp; Finalizados &nbsp;&nbsp;<span class='statusAguardando'></span> Parc. Finalizado");
            $(".statusAtendimentosViewPaciente").append("&nbsp;&nbsp;<span class='statusEmAndamento'></span> Em Andamento &nbsp;&nbsp;<span class='statusPendencias'></span> Existem Pendências");
            $(".txtRodapePostoPac").append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-heartbeat'></i> Posto/Atendimento &nbsp;");
            $(".txtRodapePostoPac").append("&nbsp;| &nbsp;<i class='fa fa-credit-card'></i> Convênio &nbsp");
    </script>
@stop