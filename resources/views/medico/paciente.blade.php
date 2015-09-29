@extends('layouts.layoutBaseLeft')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
@show

@section('infoHead')
    <div class="feed-element pull-right infoUser">
        <a href="#" class="boxImgUser">
          {!! Html::image('/assets/images/medico.png','logoUser',array('class' => 'img-circle pull-left')) !!}
        </a>
        <div class="media-body">
            <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span>
            <a class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-caret-square-o-down fa-2x"></b></a><br>
            {{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;            
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
                       data-idade="{{$atendimento->data_nas}}"
                       data-idade="{{$atendimento->sexo}}"
                       data-nome="{{$atendimento->nome}}">                       
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
<div id="page-wrapper" class="gray-bg" style="min-height: 85.6vh;">
    <div class="row infoClienteMed">
        <div class="col-md-12 colunaInfoPaciente">
            <div class="col-md-5">
                <div class="infoPaciente">
                    <strong><span id="nome" class="nomePaciente"></span></strong> <br>
                    <div class="idadePaciente"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="infoAtendimentoMedico">
                    <i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="right" title="Posto/Atendimento"></i>
                    <span id="atendimento"></span> <br>
                    <i class="fa fa-credit-card" data-toggle="tooltip" title="Convênio"></i>
                    <span id="convenio"></span> <br>                           
                </div>
            </div>
            <div class="col-md-2 areaBtnVoltar"></div>
        </div>
    </div>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">
            <div class="row">
                <div class="i-checks all boxSelectAll"> </div>
           </div>
         <ul class="sortable-list connectList agile-list ui-sortable listaExames">  </ul>


            <!-- Modal -->
              <div class="modal fade" id="modalExames" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Exames Descrição</h4>
                    </div>
                    <div class="modal-body">
                      <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>
        </div>
    </div>
    <div class="footer">
        <div class="pull-left">
            {!!config('system.loginText.footerText')!!}
        </div>
        <div class="pull-right" id="boxRodape">

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

    <script type="text/javascript">
        $(document).ready(function () {
            var posto;
            var atendimento;
            var nomeSolicitante;
            var nomeConvenio;
            var nomePaciente;

            var controle;

            $('.btnAtendimento').click(function(e){
                posto = $(e.currentTarget).data('posto');
                atendimento = $(e.currentTarget).data('atendimento');
                nomeSolicitante = $(e.currentTarget).data('solicitante');
                nomeConvenio = $(e.currentTarget).data('convenio');
                saldo = $(e.currentTarget).data('saldo');
                idade = $(e.currentTarget).data('idade');
                sexo = $(e.currentTarget).data('sexo');
                nomePaciente = $(e.currentTarget).data('nome');

                $('.idadePaciente').html('');
                $('.idadePaciente').append('<i class="'+((sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> <span id="idade"></span>');

                var dataNascimento = moment(idade).format('DD/MM/YYYY');
                var idadeCliente = new moment().diff(idade, 'years');  

                $('#idade').html(dataNascimento + ' - ' + idadeCliente + ' Anos');

                if(posto != null && atendimento != null){
                    getExames(posto,atendimento);
                }

                $('.boxSelectAll').html('');
            });

           
            $('.page-heading').slimScroll({
                height: '66.5vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            });

            $('#side-menu').slimScroll({
                height: '65vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            });          

            $('.active a').trigger('click');

            $('.areaBtnVoltar').append('<button type="button" class="btn btn-w-m btn-default btnVoltar pull-right"><i class="fa fa-arrow-circle-o-left"></i> Voltar</button>');

            $('.btnVoltar').click(function(){
                window.location.replace("/medico");
            });

            $("#btnViewExame").click(function(){
                $("#modalExames").modal();
            });

            function verificaSaldoDevedor(saldo,situacao){
                if(saldo == null || saldo == 0 && situacao == "success-element")
                   return true;
            }

            function getExames(posto,atendimento){
                controle = false;

                //Carregando
                $('.listaExames').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');

                //Pega os dados via get de exames do atendimento
                $.get( "/medico/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    $('#nome').html(nomePaciente);
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

                        if(!verificaSaldoDevedor(saldo)){
                            if(exame.class == 'success-element'){
                                $('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');
                                if(exame.tipo_entrega == '*'){
                                    link = '<a id="btnViewExame" data-toggle="modal"'+
                                           'data-tipoEntrega="'+exame.tipo_entrega+'" data-posto="'+exame.posto+
                                           '" data-atendimento="'+exame.atendimento+'" data-correl="'+exame.correl+
                                           '" data-target="#modalExames">';

                                    check = '<div class="i-checks checkExames"><input type="checkbox" class="check"></div>';
                                }else{
                                    msg = 'Só pode ser impresso no lab.';
                                }
                            }
                        }

                        conteudo = link+'<div class="'+sizeBox+' boxExames"><li class="'+exame.class+' animated fadeInDownBig">'+check+
                                        '<div class="dadosExames">' +
                                            '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+
                                            '<br>'+exame.msg+'<br>'+msg+'</li></div>';

                        conteudo += ((link != '') ? '</a>' : '');
                        $('.listaExames').append(conteudo);
                    });

                    var checkAll = $('input.checkAll');
                    var checkboxes = $('input.check');

                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-grey',
                    });

                    
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
                                $('#boxRodape').html('');
                            } else {
                                $('#boxRodape').html('<button type="button" class="btn btn-danger btnPdf">Gerar PDF</button>');
                            }
                            checkAll.iCheck('update');
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
                          
                    }else{
                        $('#boxRodape').html('<h3 class="text-danger">{!!config('system.messages.paciente.saldoDevedor')!!}</h3>');
                    }
                }, "json" );
            }
        });
    </script>
@stop