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
                    <a href="/auth/logout">
                        <i class="fa fa-sign-out"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('left')
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="topoMenu">
            <strong>Relação de Atendimentos</strong>
        </div>
        <ul class="nav metismenu" id="side-menu">
            @foreach($atendimentos as $key => $atendimento)
                <li class="{{ !$key ? 'active' : '' }}">
                    <a href="#" class="btnAtendimento"
                       data-posto="{{$atendimento->posto}}"
                       data-atendimento="{{$atendimento->atendimento}}"
                       data-solicitante="{{$atendimento->nome_solicitante}}"
                       data-convenio="{{$atendimento->nome_convenio}}"
                       data-saldo="{{$atendimento->saldo_devedor}}"
                       data-idade="{{$atendimento->idade}}"
                       data-sexo="{{$atendimento->sexo}}"
                       data-mnemonicos="{{$atendimento->mnemonicos}}"
                       data-nome="{{$atendimento->nome}}"> 
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@stop

@section('content')
<div id="page-wrapper-posto" class="gray-bg">
    <div class="row-fluid">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <button type="button" class="btn btn-default btn-circle btn-md btnVoltar pull-left">
                <i class="fa fa-reply" style="font-size:18px"></i>
            </button>
            <strong><span id="nome" class="nomePaciente"></span></strong><br>
            <div class="idadePaciente"></div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-3">
            <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"></i>
            <span id="atendimento"></span>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-3">
            <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="bottom" title="Convênio"></i>
            <span id="convenio"></span>
        </div>
    </div>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <div class="row">
                <div class="i-checks all boxSelectAll"> </div>
            </div>        
            <ul class="sortable-list connectList agile-list ui-sortable listaExames">  </ul>
              <div class="modal fade" id="modalExames" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2 class="modal-title">Exames Descrição</h2>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                  </div>                  
                </div>
              </div>
        </div>
          <div class="footer">
            <div class="row">                
                <div class="col-sm-4 txtRodapePostoPac">    </div>  
                <div class="col-sm-6" id="boxRodapePostoPac">    </div>
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
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>    
    <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script> 

    <script type="text/javascript">
        $(document).ready(function () {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });  
            
            var posto;
            var atendimento;
            var nomeSolicitante;
            var nomeConvenio;
            var nomePaciente;
            var mnemonicos;

            var controle;

            $('.btnAtendimento').click(function(e){
                posto = $(e.currentTarget).data('posto');
                atendimento = $(e.currentTarget).data('atendimento');
                nomeSolicitante = $(e.currentTarget).data('solicitante');
                nomeConvenio = $(e.currentTarget).data('convenio');
                saldo = $(e.currentTarget).data('saldo');
                nomePaciente = $(e.currentTarget).data('nome');
                idade = $(e.currentTarget).data('idade');
                sexo = $(e.currentTarget).data('sexo');
                mnemonicos = $(e.currentTarget).data('mnemonicos'); 

                $('.idadePaciente').append('<i class="'+((sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> <span id="idade"></span>');
                $('#idade').html(idade);

                if(mnemonicos == ""){
                     swal("Não foram realizados exames para este atendimento.");
                }

                if(posto != null && atendimento != null){
                    getExames(posto,atendimento);
                }

                $('.boxSelectAll').html('');
            });

            $('.btnAtendimento').hide(); 
            $('.btnAtendimento').trigger('click');         
            $('.navbar-static-side').remove();   

            $('.ibox').slimScroll({
                height: '70vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            });   

            $('.modal-body').slimScroll({
                height: '55.0vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            }); 

            $('.btnVoltar').click(function(){
                window.location.replace("/posto");
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
                $.get( "/posto/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    $('#nome').html(nomePaciente);
                    $('#solicitante').html(nomeSolicitante);
                    $('#convenio').html(nomeConvenio);
                    $('#atendimento').html("00/00"+atendimento);

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
                                        '<div style="display:none">'+exame.nome_posto_realizante+'</div>'+
                                        '<div class="dadosExames">' +
                                            '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+
                                            '<br>'+exame.msg+'<br><span class="msgExameTipoEntrega">'+msg+'</span></li></div>';

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
                        $('.modal-body').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   
                        $('.modal-footer').html('');    

                        $.ajax({
                            url : '/posto/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
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
                                $('.modal-body').html(''); 

                                $('.modal-footer').append('Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+' - '+
                                    descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Data e Hora da Coleta: '+descricao.DATA_COLETA);

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

                                    conteudo = '<div class ="col-md-12 descricaoExames">'+
                                                 '<div class="col-md-8 analitos">'+
                                                    ''+analitos[index].ANALITO+'</div>'+
                                                 '<div class="col-md-4 valoresAnalitos">'+
                                                    '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong></div>'+
                                                 '</div>';

                                    $('.modal-body').append(conteudo);

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
                             url: '/posto/exportarpdf',
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
                        $('#boxRodapePostoPac').html('<h3 class="text-danger">{!!config('system.messages.pacientes.saldoDevedor')!!}</h3>');
                        $('#boxRodapePostoPac').css("margin-right", "0px");
                    }
                }, "json" );
            }
        });
            $(".txtRodapePostoPac").append("<span class='statusAtendimentosViewPaciente'></span>");            
            $(".statusAtendimentosViewPaciente").append(" <span class='statusFinalizados'></span>&nbsp; Finalizados &nbsp;&nbsp;<span class='statusAguardando'></span> Parc. Finalizado");
            $(".statusAtendimentosViewPaciente").append("&nbsp;&nbsp;<span class='statusEmAndamento'></span> Em Andamento &nbsp;&nbsp;<span class='statusPendencias'></span> Existem Pendências");
            $(".txtRodapePostoPac").append('<br><span class="devFooter">{!!config('system.loginText.footerText')!!}</span>');
    </script>
@stop