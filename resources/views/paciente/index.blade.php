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
                {{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;
            </button> 
            <ul class="dropdown-menu pull-right itensInfoUser">             
                @if(Auth::user()['tipoLoginPaciente'] == 'CPF')
                    <li class="item">
                        <a class="btnShowModal">
                            <i class="fa fa-user"></i> Alterar Senha
                        </a>
                    </li>
                @endif
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
                <li class="leftMenu {{ !$key ? 'active' : '' }}">
                    <a href="#" class="btnAtendimento"
                       data-posto="{{$atendimento->posto}}"
                       data-atendimento="{{$atendimento->atendimento}}"
                       data-solicitante="{{$atendimento->nome_solicitante}}"
                       data-convenio="{{$atendimento->nome_convenio}}"
                       data-mnemonicos="{{$atendimento->mnemonicos}}"
                       data-saldo="{{$atendimento->saldo_devedor}}">
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
    <div class="row infoCliente">
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
            <div class="col-xs-4">
                <div class="convenioPaciente">
                    <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="bottom" title="Convênio"> </i>
                    <span id="convenio"></span> 
                </div>                   
            </div>
        </div>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <div class="row">
                <div class="i-checks all boxSelectAll"> </div>
            </div>
            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
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
                @if(Auth::user()['tipoLoginPaciente'] == 'CPF')
                    <div class="modal fade" id="modalAlterarSenha" role="dialog">
                        <div class="modal-dialog">                
                            <div class="modal-conteudo">
                                <div class="modal-topo">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h2 class="modal-titulo">Alterar senha de acesso</h2>
                                </div>
                                {!! Form::open(array('id' => 'formSenha')) !!}
                                    <div class="modal-corpo">
                                        <div id="msg"></div>
                                        <div class="col-md-12">
                                            {!! Form::label('SenhaAtual', 'Senha Atual') !!}
                                            {!! Form::password('senhaAtual',array('class' => 'form-control', 'id' =>'senhaAtual', 'placeholder' => 'Senha Atual' )) !!}                                 
                                        </div>
                                        <div class="col-md-12">
                                            {!! Form::label('novaSenha', 'Nova Senha') !!}
                                            {!! Form::password('novaSenha',array('class' => 'form-control', 'id' =>'novaSenha', 'placeholder' => 'Nova Senha' )) !!}                                
                                        </div>
                                        <div class="col-md-12">
                                            {!! Form::label('confirmarSenha', 'Confirmar Nova Senha') !!}
                                            {!! Form::password('confirmarSenha',array('class' => 'form-control', 'id' =>'confirmarSenha', 'placeholder' => 'Confirmar Nova Senha' )) !!}             
                                        </div>
                                    </div>
                                    <div class="modal-rodape">
                                        <a class="btn btn-success" id="btnSalvarPerfil">Salvar</a>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </ul>
        </div>
    </div>
    <div class="footer">
        <div class="row col-md-12">
            <div class="col-md-4 pull-right" id="boxRodape"></div>
            <div class="col-md-8 txtRodape"></div>  
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

            var posto;
            var atendimento;
            var nomeSolicitante;
            var nomeConvenio;
            var mnemonicos;

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

                if(mnemonicos == ""){                    
                    swal("Não foram realizados exames para este atendimento.");
                }

                if(posto != null && atendimento != null){
                    getExames(posto,atendimento);
                }

                $('.boxSelectAll').html('');
            });

            $('.btnShowModal').click(function(e){
                $('#modalAlterarSenha').modal('show');
                $('#msg').html(' ');
                $('#senhaAtual').val('');
                $('#novaSenha').val('');
                $('#confirmarSenha').val('');       
                $('.modal-rodape').css('border-top','solid 0px black');        
            });

            $('#btnSalvarPerfil').click(function(e){                

                if(form.valid()){
                    //serializa dos dados do formulario
                    var postData = form.serializeArray();

                    $.ajax({
                        url : '{{url()}}/paciente/alterarsenha',
                        type: 'POST',
                        data : postData,
                        success:function(data, textStatus, jqXHR) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);
                            var style = (jqXHR['status'] == 200 ? 'success':'danger');

                            $('#msg').html('<div class="alert alert-'+style+' alert-dismissable animated fadeIn">'+msg.message+'</div>');    
                        },
                        error: function(jqXHR, textStatus, errorThrown) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);

                            $('#msg').html('<div class="alert alert-danger alert-dismissable animated fadeIn">'+msg.message+'</div>');
                        }
                    });
                }else{
                    $('#msg').html('<div class="alert alert-danger alert-dismissable animated fadeIn">Preencha os dados corretamente</div>');
                }

                e.preventDefault();                
            });

            $('.ibox').slimScroll({
                height: '69vh',              
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

            $('#side-menu').slimScroll({
                height: '71.2vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            });         

            $('.leftMenu.active a').trigger('click');

            function verificaSaldoDevedor(saldo){
                if(saldo == null || saldo == 0){
                   return false;
                }
                return true;
            }

            function getExames(posto,atendimento){
                //Carregando
                $('.listaExames').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                //Pega os dados via get de exames do atendimento
                $.get( "/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    $('#solicitante').html(nomeSolicitante);
                    $('#convenio').html(nomeConvenio);
                    $('#atendimento').html("00/00"+atendimento);
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
                                getDescricaoExame(dadosExames);                 
                            }
                            else{
                                return false;
                            }
                    });     

                    function getDescricaoExame(dadosExames){ 
                         $('.modal-body').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');   
                         $('.modal-title').html('');
                         $('.modal-footer').html('');
                        $.ajax({
                            url : '/paciente/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
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

                                $('#modalExames').modal('show');  
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
                                    $('.modal-body').append('<h2 class="textoTamanho">NÃ£o foram encontrados atendimentos.</h2>');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                $('.modal-body').html('');
                                $('.modal-body').append('<div class="text-center alert alert-danger animated fadeIn erroDescricao"><i class="fa fa-exclamation-circle fa-5x"><h2>Erro ao carregar Descrição do Exame.</h2></div>');
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

                             $.ajax({ // Faz verificaÃ§Ã£o de dados do cliente dentro do formulario(modal) de cadastrar senha.
                                 url: 'paciente/exportarpdf',
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
                        $('#boxRodape').html('<h3 class="text-danger msgCliente">{!!config('system.messages.pacientes.saldoDevedor')!!}</h3>');
                    }
                }, "json" );
            }
        });         
            $(".txtRodape").append("<span class='statusAtendimentosViewPaciente'></span>");            
            $(".statusAtendimentosViewPaciente").append(" <span class='statusFinalizados'></span>&nbsp; Finalizados &nbsp;&nbsp;<span class='statusAguardando'></span> Parc. Finalizado");
            $(".statusAtendimentosViewPaciente").append("&nbsp;&nbsp;<span class='statusEmAndamento'></span> Em Andamento &nbsp;&nbsp;<span class='statusPendencias'></span> Existem Pendências");
            $(".txtRodape").append('<br><span class="devFooter">{!!config('system.loginText.footerText')!!}</span>');
    </script>
@stop