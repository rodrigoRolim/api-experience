@extends('layouts.layoutBase')

@section('stylesheets')
    @parent
@stop

@section('infoHead')
    <a href="#" class="boxImgUser">
       {!! Html::image('/assets/images/medico.png','logoUser',array('class' => 'img-circle pull-left')) !!}
    </a>
    <div class="media-body">
        <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span><br>        
        <a class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
        <ul class="dropdown-menu pull-right itensInfoUser">
            <li class="item">
                <a href="/auth/logout">
                    <i class="fa fa-sign-out"></i> Sair
                </a>
            </li>
        </ul>
    </div>
@stop

@section('content')
    <div class="col-md-12 corPadrao boxFiltro">
        <form id="formPosto">
            <input hidden type="text" value="0" name="posto">
            <div class="col-md-3">
                <label class="textoBranco">Atendimentos por datas entre:</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" id="dataInicio" name="dataInicio">
                    <span class="input-group-addon">até</span>
                    <input type="text" class="input-sm form-control" id="dataFim" name="dataFim">                    
                </div>
            </div>            
            <div class="col-md-3">
                <label class="textoBranco" name="convenio">Convênios</label>
                {!! Form::select('convenio', $convenios, '', array('class' => 'form-control m-b', 'id'=>'convenio')) !!}
            </div>
            <div class="col-md-2">
                <label class="textoBranco" name="situacao">Situação</label>
                {!! Form::select('situacao', config('system.selectFiltroSituacaoAtendimento'), '', array('class' => 'form-control m-b', 'id'=>'situacao')) !!}
            </div>
            <div class="col-md-2">
                <div class="input-group m-b filtrar col-md-12" style="margin-bottom:0px;padding-top:17px;">
                    <a class="btn btn-warning btn-outline col-md-12" id="btnFiltrar"><i class="fa fa-filter fa-2"> </i> Filtrar</a>
                </div>
            </div>
        </form>
    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox-content">
            <div class="row">
                <div class="input-group m-b">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" id="filtroPaciente" placeholder="Localizar paciente na relação abaixo" class="form-control">
                </div>
                <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter"></ul>                
            </div>
        </div>
    </div>
@stop


@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            var dataInicio = new moment();
            var dataFim = new moment();
            var qtdDiasFiltro = {{config('system.medico.qtdDiasFiltro')}};

            $('.input-daterange').datepicker({
                keyboardNavigation: true,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
            dataInicio = dataInicio.format('DD/MM/YYYY');
            dataFim = dataFim.format('DD/MM/YYYY');

            $('#dataInicio').val(dataInicio);
            $('#dataFim').val(dataFim);

            $('#listFilter').slimScroll({
                height: '60vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
            });

            $('#filtroPaciente').filterList();

            $('#btnFiltrar').click(function(e){
                var formPosto = $('#formPosto');
                var postData = formPosto.serializeArray();

                getClientes(postData);
            });



            function getClientes(postData){
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                $.ajax({
                    url : 'posto/filterclientes',
                    type: 'POST',
                    data : postData,
                    success:function(result){
                        $('#listFilter').html('');

                        $.each( result.data, function( index ){
                            var cliente = result.data[index];
                            var item =   '<li class="col-md-12 naoRealizado-element" data-key="'+cliente.key+'">'+
                                            '<div class="col-md-4 dadosPaciente text-left">'+
                                                '<strong>'+cliente.nome+'</strong><br><i class="'+((cliente.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> &nbsp;'+cliente.idade+
                                            '</div>'+
                                            '<div class="col-md-2 text-left"><span class="ajusteFonte">Contato: '+cliente.telefone+' </span></div>'+
                                            '<div class="col-md-6 text-left"><span class="ajusteFonte">Últ. Atendimentos: </span>';
                            var count = 0;

                            $.each( cliente.atendimentos, function( index ){
                                count++;
                                var atendimento = cliente.atendimentos[index];
                                item += '<span class="label labelAtendimentosClientes">'+atendimento+"</span>";

                                if(count == 3){
                                    return false;
                                }
                            });

                            item += '</div></li>';

                            $('#listFilter').append(item);
                           
                        });

                        $('#listFilter li').click(function(e){
                            var key = $(e.currentTarget).data('key');
                            window.location.replace("/medico/paciente/"+key);
                        });

                        console.log(result.data.length);
                        if(result.data.length == 0){
                            $('#listFilter').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        var msg = jqXHR.responseText;
                        msg = JSON.parse(msg);
                        $('#msgPrograma').html('<div class="alert alert-danger alert-dismissable animated fadeIn">'+msg.message+'</div>');
                    }
                });
            }
        });
    </script>
@stop