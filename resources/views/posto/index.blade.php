@extends('layouts.layoutBase')

@section('stylesheets')
    @parent
@stop

@section('infoHead')
    <a href="#" class="boxImgUser">
       {!! Html::image('/assets/images/medico.png','logoUser',array('class' => 'img-circle pull-left')) !!}
    </a>
    <div class="media-body">
        <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span>      
        <a class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-caret-square-o-down fa-2x"></b></a>
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
    <div class="col-md-12 corPadrao boxFiltroPosto">
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
            var qtdDiasFiltro = {{config('system.posto.qtdDiasFiltro')}};

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
                height: '80vh',
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

            $('#btnFiltrar').trigger('click');
            
            function getClientes(postData){
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                $.ajax({
                    url : 'posto/filteratendimentos',
                    type: 'POST',
                    data : postData,
                    success:function(result){   
                        $('#listFilter').html('');
                        var dataAtendimento = [];

                        $.each( result.data, function( index ){
                            var atendimento = result.data[index];
                            console.log(atendimento);
                            atendimento.telefone = atendimento.telefone.replace(/ /g,""); //Remove espaços
                            dataAtendimento = new moment(atendimento.data_atd);                            
                            dataAtendimento = dataAtendimento.format('DD/MM/YYYY');     
                            dataNascimento = new moment(atendimento.data_nas);
                            dataNascimento = dataNascimento.format('DD/MM/YYYY');

                            var item =   '<li class="col-sm-12 boxatendimento naoRealizado-element" data-key="'+atendimento.key+'">'+
                                            '<div class="col-sm-12 dadosPaciente text-left">'+
                                              '<div class="col-sm-6">'+
                                                '<span class="postoAtendimento"><i class="fa fa-heartbeat"></i><strong> '+atendimento.posto+'/'+atendimento.atendimento+'</span></strong>'+
                                                '<span class="dataAtendimento"><i class="fa fa-calendar-check-o"></i> '+dataAtendimento+'</span>'+
                                                '<span class="convenioAtendimento"><i class="fa fa-credit-card"></i> '+atendimento.nome_convenio+'</span>'+                                                
                                                '<div class="dadosPessoais"><strong>'+atendimento.nome+'</strong>'+' <br><i class="'+((atendimento.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i>'+atendimento.idade+'  '+dataNascimento+'</div>'+
                                               '</div><div class="col-sm-6">'+
                                                '<i class="fa fa-flask"></i> '+atendimento.mnemonicos+'</div>'+
                                            '</div></li>';  

                            $('#listFilter').append(item);
                           
                        });

                        $('#listFilter li').click(function(e){
                            var key = $(e.currentTarget).data('key');
                            window.location.replace("/posto/paciente/"+key);
                        });
                        
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