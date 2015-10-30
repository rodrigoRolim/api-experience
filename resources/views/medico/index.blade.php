@extends('layouts.layoutBase')

@section('stylesheets')
    @parent
@stop

@section('infoHead')
     <div class="pull-right media-body">        
        <button data-toggle="dropdown" class="btn btn-usuario dropdown-toggle boxLogin">
            <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span> <span class="caret"></span><br>
            {{date('d/m/y',strtotime(Auth::user()['data_nas']))}}&nbsp;
        </button>         
        <ul class="dropdown-menu pull-right itensInfoUser">
            <li class="item"><a class="btnShowModal"><i class="fa fa-user"></i> Alterar Senha</a></li>
            <li class="item"><a href="{{url()}}/auth/logout"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </div>    
@stop

@section('content')
<button class="menu-trigger text-center"> <i class="fa fa-filter fa-2x"> </i> Filtrar Atendimentos </button>
    <div class="col-md-12 corPadrao boxFiltro">
        <form id="formMedico">
            <div class="col-md-3">
                <label class="textoBranco">Atendimentos por datas entre:</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" id="dataInicio" name="dataInicio">
                    <span class="input-group-addon">até</span>
                    <input type="text" class="input-sm form-control" id="dataFim" name="dataFim">
                </div>
            </div>
            <div class="col-md-2">
                <label class="textoBranco" name="posto">Posto de Cadastro</label>
                {!! Form::select('posto', $postos, '', array('class' => 'form-control m-b', 'id'=>'posto')) !!}
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
                <div class="contadorAtd">                    
                </div>
                <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter"></ul>
            </div>
        </div>
    </div>

    @include('medico.modalAlterarSenha')
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>    
    <script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){

            $(".menu-trigger").click(function() {
                $(".boxFiltro").slideToggle(400, function() {
                    $(this).toggleClass("nav-expanded").css('display', '');
                });

            });            
            
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

            VMasker($("#dataInicio")).maskPattern('99/99/9999');
            VMasker($("#dataFim")).maskPattern('99/99/9999');

            $('#listFilter').slimScroll({
                height: '61vh',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                touchScrollStep: 50,
                alwaysVisible: true
            });


            $('#filtroPaciente').filterList();             

            $('#btnFiltrar').click(function(e){
                var formMedico = $('#formMedico');
                var postData = formMedico.serializeArray();

                getClientes(postData);
            });

            $('#btnFiltrar').trigger('click');

            function getClientes(postData){
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                $.ajax({
                    url : 'medico/filterclientes',
                    type: 'POST',
                    data : postData,
                    success:function(result){
                        $('#listFilter').html('');

                        $.each( result.data, function( index ){
                            var cliente = result.data[index];
                            $('.contadorAtd').html('<h5 class="achouAtd">Foram encontrados ' + result.data.length + ' atendimentos para as datas selecionadas   .</h5>');

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
                        
                        if(result.data.length == 0){
                            $('#listFilter').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
                            $('.contadorAtd').html('');
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