@extends('layouts.layoutPaciente')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
@show





@section('infoAtendimento')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-10">
                <div class="infoAtendimento">
                    <span><strong>Convênio</strong>:</span>
                    <span id="convenio"></span> <br>
                    <span><strong>Solicitante</strong>:</span>
                    <span id="solicitante"></span>
                </div>
            </div>
			<span class="atendimento"><strong>ID</strong>:
				<span id="atendimento"></span></span>
        </div>
    </div>
@stop

@section('exames')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="ibox">

        <div class="i-checks all boxSelectAll"> </div>
            <ul class="sortable-list connectList agile-list ui-sortable listaExames"></ul>
        </div>
    </div>


@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/truncateString/truncate.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var posto;
            var atendimento;
            var nomeSolicitante;
            var nomeConvenio;       

            var controle;

            $('.btnAtendimento').click(function(e){
                posto = $(e.currentTarget).data('posto');
                atendimento = $(e.currentTarget).data('atendimento');
                nomeSolicitante = $(e.currentTarget).data('solicitante');
                nomeConvenio = $(e.currentTarget).data('convenio');
                saldo = $(e.currentTarget).data('saldo');

                if(posto != null && atendimento != null){
                    getExames(posto,atendimento);
                }

                $('.boxSelectAll').html('');
            });

            $("#btnViewExame").click(function(){
                $("#modalExames").modal();
            });

            $('.active a').trigger('click');

            $('.topoMenu').append('<button type="button" class="btn btn-w-m btn-default btnVoltar"><i class="fa fa-arrow-circle-o-left"></i> Voltar</button>')


            function getExames(posto,atendimento){
                controle = false;

                //Carregando
                $('.listaExames').html('<br><br><br><br><h2 class="text-center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');

                //Pega os dados via get de exames do atendimento
                $.get( "/medico/examesatendimento/"+posto+"/"+atendimento, function( result ) {
                    //Carrega dados do atendimento
                    $('#solicitante').html(nomeSolicitante);
                    $('#convenio').html(nomeConvenio);
                    $('#atendimento').html("00/00"+atendimento);
                    
                    $('.listaExames').html('');
                    $('#boxRodape').html('');

                    $.each( result.data, function( index, exame ){
                        var sizeBox = 'col-md-6';
                        var element = '<a id="btnViewExame" data-toggle="modal" data-target="#modalExames">'+
                                '<div class="'+sizeBox+' boxExames">' +
                                '<li class="'+exame.class+' animated fadeInDownBig">' +
                                '<div class="dadosExames">' +
                                '<b>'+exame.mnemonico+'</b> | '+exame.nome_procedimento.trunc(31)+'<br>'+exame.msg+
                                '</div>';

                        if(saldo == null || saldo == 0 && exame.class == "success-element"){
                            controle = true;

                            element += '<div class="i-checks checkExames">'+
                                    '<input type="checkbox" class="check">'+
                                    '</div>';
                        }

                        element += '</li></div></a>';
                        $('.listaExames').append(element);
                    });

                    if(controle){
                        $('.boxSelectAll').html('<span>Selecionar Todos &nbsp;<input type="checkbox" class="checkAll"></span>');

                        var checkAll = $('input.checkAll');
                        var checkboxes = $('input.check');

                        $('input').iCheck({
                            checkboxClass: 'icheckbox_square-grey',
                        });
                    }

                    //verifica se o usuario tem saldo devedor
                    if(saldo == null || saldo == 0){
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