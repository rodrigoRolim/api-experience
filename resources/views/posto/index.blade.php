@extends('layouts.layoutBase')

@section('stylesheets')
    @parent
@stop

@section('infoHead')
    <div class="media-body">        
        <button data-toggle="dropdown" class="btn btn-usuario dropdown-toggle boxLogin">
            <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span> <span class="caret"></span><br>
        </button>         
        <ul class="dropdown-menu pull-right itensInfoUser">            
            <li class="item"><a href="{{url()}}/auth/logout"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </div>    
@stop

@section('content')
    <button class="menu-trigger text-center"> <i class="fa fa-filter fa-1x"> </i> Filtrar Atendimentos </button>
    <div class="col-md-12 corPadrao boxFiltroPosto">       
        <form id="formPosto">
            <input hidden type="text" value="0" name="posto">
            <div class="col-md-3">
                <label class="textoBranco">Periodo:</label>
                <div class="input-daterange input-group" id="datepicker" data-provide="datepicker" data-date-end-date="0d">
                    <input type="text" class="input-sm form-control" id="dataInicio" name="dataInicio">
                    <span class="input-group-addon">até</span>
                    <input type="text" class="input-sm form-control" id="dataFim" name="dataFim">                    
                </div>
            </div>       
            <div class="col-md-2">
                <label class="textoBranco" name="acomodacao">Acomodação</label>
                {!! Form::select('acomodacao', [], '', array('class' => 'form-control m-b', 'id'=>'acomodacao')) !!}
            </div>
            <div class="col-md-2">
                <label class="textoBranco" name="situacao">Situação</label>
                {!! Form::select('situacao', config('system.selectFiltroSituacaoAtendimento'), '', array('class' => 'form-control m-b', 'id'=>'situacao')) !!}
            </div>
            <div class="col-md-3">
                <label class="textoBranco" name="situacao">Posto Realizante</label>
                {!! Form::select('postoRealizante', $postoRealizante, '', array('class' => 'form-control m-b', 'id'=>'postoRealizante')) !!}
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
            <div class="input-group m-b inputBuscaPaciente">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="filtroPaciente" placeholder="Localizar Paciente" class="form-control">
            </div>
            <div class="contadorAtd"></div>
            <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter"></ul>  
        </div>
    </div>

    @include('layouts.includes.base.modalSeachAtendimento');
@stop

@section('statusFooter')
    <span class='statusFinalizados'></span> Finalizados <span class='statusAguardando'></span> Parc. Finalizado
    <span class='statusEmAndamento'></span> Em Andamento <span class='statusPendencias'></span> Existem Pendências

    <span class="pull-right">
        <span class="pull-left">
            <i class='fa fa-heartbeat'></i> Posto/Atendimento &nbsp;|&nbsp; <i class='fa fa-calendar-check-o'></i> Data do Atendimento |
            <i class='fa fa-credit-card'></i> Convênio &nbsp |&nbsp; <i class='fa fa-flask'></i>  Mnemônicos |
            <i class='fa fa-clock-o'></i> Previsão
        </span>
        <a href="{{url()}}/sobre" target="_blank">
            {!! Html::image(config('system.experienceLogo'), 'logo_exp', array('title' => 'eXperience - codemed','id'=>'logoRodape','style'=>'margin-right:8px')) !!}
        </a>
    </span>
    <div style="padding-left: 5px;"><i class='fa fa-keyboard-o'></i> <b>SHIFT+Z: </b> Localizar Atendimento</div>
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/js-cookie/js.cookie.js') }}"></script>

    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            //Inicia o tooltip
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            //Configura o dataPicker
            $('.input-daterange').datepicker({
                keyboardNavigation: true,
                autoclose: true,
                format: "dd/mm/yyyy",  
                disableTouchKeyboard: true
            });

            $("#dataInicio,#dataFim").on("changeDate",function (){ 
                getAcomodacao();
            });

            $(".input-daterange").attr("autocomplete", "off");

            //Prepara a data do filtro de acordo com a configuração no arquivo .env
            var dataInicio = new moment();
            var dataFim = new moment();
            var qtdDiasFiltro = {{config('system.posto.qtdDiasFiltro')}};

            dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
            dataInicio = dataInicio.format('DD/MM/YYYY');
            dataFim = dataFim.format('DD/MM/YYYY');

            //Verifica no cache se já houve uma pesquisa no filtro
            if(Cookies.get('dataInicio') != null){
                //Alimenta o filtro do os dados guardados em cache
                $('#dataInicio').val(Cookies.get('dataInicio'));  
                $('#dataFim').val(Cookies.get('dataFim'));
                $('#situacao').val(Cookies.get('situacao'));     
                $('#postoRealizante').val(Cookies.get('postoRealizante'));

            }else{
                //Alimenta o filtro com a data pre definida
                $('#dataInicio').val(dataInicio);
                $('#dataFim').val(dataFim);
            }

            //Configura o componente de lista
            $('#listFilter').slimScroll({
                height: '58vh',
                width:'100%',
                size: '12px',
                railVisible: true,
                background: '#ADADA',
                railOpacity: 0.4,
                wheelStep: 10,
                minwidth: '100%',
                allowPageScroll: true,
                touchScrollStep: 50,
                alwaysVisible: true
            });

            $("#acomodacao, #situacao, #postoRealizante").change(function(e) {
                select = e.target.id;
                stringSelect = '#'+select+' option:selected';  
                txt = $( stringSelect ).text();
                selecthashtag = '#'+select;

                if(txt == 'Todos'){
                     $(selecthashtag).css('background-color','white');
                }else{
                     $(selecthashtag).css('background-color','#E2EAE2');                    
                }

            });

            //Carrega acomodacao via ajax
            function getAcomodacao(){
                var postAcomodacao = [
                    {name:'dataInicio', 'value' : $('#dataInicio').val()},
                    {name:'dataFim', 'value' : $('#dataFim').val()}
                ];

                //Instancia a class Async
                var async = new AsyncClass();
                var dataResult = async.run('{{url("/")}}/posto/selectacomodacao',postAcomodacao,'POST');

                dataResult.then(function(result){
                    var selectAcomodacao = $('#acomodacao');
                    selectAcomodacao.empty();

                    $.each(result.data,function(key,value){
                        selectAcomodacao.append($("<option/>").val(key).text(value));
                    });
                    
                    $('#acomodacao').val(Cookies.get('acomodacao'));
                    //Dispara o evento do botao click para iniciar a busca inicial            
                    $('#btnFiltrar').trigger('click');
                });
            }

            //Abre filtro quando ta reduzido
            $(".menu-trigger").click(function() {
               $(".boxFiltroPosto").slideToggle(768, function() {
                   $(this).toggleClass("nav-expanded").css('display', '');
               });
           });  

            //Evento do disparo do botão de filtro
            $('#btnFiltrar').click(function(e){
                Cookies.set('dataInicio', $('#dataInicio').val());
                Cookies.set('dataFim', $('#dataFim').val());
                Cookies.set('acomodacao', $('#acomodacao').val());
                Cookies.set('situacao', $('#situacao').val());
                Cookies.set('postoRealizante', $('#postoRealizante').val());

                var formPosto = $('#formPosto');
                var postData = formPosto.serializeArray();

                //Instancia a class Async
                var async = new AsyncClass();

                //Busca os dados do atendimento do posto
                var dataResult = async.run('{{url("/")}}/posto/filteratendimentos',postData,'POST');
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');                
                
                dataResult.then(function(result){
                    //Limpa a div de filter
                    $('#listFilter').html('');
                    //Prepara HTML para impressao no listFilter
                    $.each( result.data, function( index ){
                        var atendimento = result.data[index];

                        //Impressao da quantidade de atendimentos localizados
                        $('.contadorAtd').html('<h5 styçe="margin-bottom: 0px;" class="achouAtd">Foram encontrados '+result.data.length+' atendimentos para o filtro selecionado.</h5>');
                        //Prepara htmk do LI
                        var item = '<li class="col-sm-12 boxatendimento '+atendimento.situacaoAtendimento+'"data-key="'+atendimento.key+'" data-atendimento="'+atendimento.atendimento+'" data-posto="'+atendimento.posto+'">'+
                            '<div class="row">'+
                                '<div class="col-md-4 col-sm-6 col-xs-12">'+
                                    '<strong>'+atendimento.nome+'</strong>'+'<br>'+'<i class="'+((atendimento.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> '+atendimento.idade+
                                '</div>'+
                                '<div class="col-md-2 col-sm-6 col-xs-6">'+
                                    '<i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="right" title="Posto/Atendimento"></i><strong> '+atendimento.posto+'/'+atendimento.atendimento+'</strong>'+                                                    
                                '</div>'+
                                '<div class="col-md-2 col-sm-6 col-xs-6">'+
                                    '<i class="fa fa-calendar-check-o" data-toggle="tooltip" title="Data do Atendimento"></i> '+atendimento.data_atd+
                                '</div>'+
                                '<div class="col-md-2 col-sm-6 col-xs-6 hidden-xs">'+
                                    '<i class="fa fa-credit-card" data-toggle="tooltip" title="Convênio"></i> '+atendimento.nome_convenio+
                                '</div>';

                        if(atendimento.situacao_exames_experience != 'TF' && atendimento.data_entrega != false && atendimento.data_entrega != null){
                           item += '<div class="col-md-2 col-sm-6 col-xs-12">'+
                                    '<i class="fa fa-clock-o" data-toggle="tooltip" title="Previsão de entrega"></i> '+atendimento.data_entrega+
                            '</div>';
                        }
                        
                        item += '<div class="col-md-12 col-sm-6 col-xs-12">'+
                                    '<i class="fa fa-flask" data-toggle="tooltip" title="Mnemônicos"></i> '+atendimento.mnemonicos+
                                '</div>'+
                            '</div>'+
                       '</li>';
                       //Adiciona o item na lista
                       $('#listFilter').append(item);
                    });

                    $('#listFilter li').click(function(e){
                        var key = $(e.currentTarget).data('key');
                        var posto = $(e.currentTarget).data('posto');
                        var atendimento = $(e.currentTarget).data('atendimento');

                        $(window.document.location).attr('href',"{{url('/')}}/posto/paciente/"+key+"/"+posto+"/"+atendimento);
                    });

                    //Caso houver erro para a execução e imprime no alert
                    if(!result.status){
                        $('#msgPrograma').html('<div style="margin-top:20vh" class="alert alert-danger alert-dismissable animated fadeIn">'+result.msgError+'</div>');
                    }

                    //Caso não retorne atendimento imprime a mensagem
                    if(!result.data.length){
                        $('#listFilter').append('<h2 class="textoTamanho" style="padding-top:24vh">Não foram encontrados atendimentos para esse filtro.</h2>');
                        $('.contadorAtd').html('');
                    }

                    //Habilita a busca
                    $('#filtroPaciente').filterList();                    
                });                
            });
            
            getAcomodacao();
        });
    </script>
@stop