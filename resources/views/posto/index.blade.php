@extends('layouts.layoutBase')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
    @parent
@stop

@section('infoHead')
    <div class="media-body">        
        <button data-toggle="dropdown" class="btn btn-usuario dropdown-toggle boxLogin">
            <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span> <span class="caret"></span><br>
        </button>         
        <ul class="dropdown-menu pull-right itensInfoUser">
            <li class="item imprimirTimbrado"><input id="checkTimbrado" type="checkbox"></i>&nbsp; Imprimir Cabeçalho</li>
            <li style="border-bottom:1px solid #efefef; margin-top:8px"></li>          
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
                <div class="input-daterange input-group">
                    <input type="text" class="input-sm form-control datepicker" id="dataInicio" name="dataInicio">
                    <span class="input-group-addon">até</span>
                    <input type="text" class="input-sm form-control datepicker" id="dataFim" name="dataFim">                    
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
                {!! Form::select('postoRealizante', [], '', array('class' => 'form-control m-b', 'id'=>'postoRealizante')) !!}
            </div>
            <div class="col-md-2">
                <div class="input-group m-b filtrar col-md-12" style="margin-bottom:0px;padding-top:17px;">
                    <a class="btn btn-warning btn-outline col-md-12 not-active" id="btnFiltrar"><i class="fa fa-filter fa-2"> </i> Filtrar</a>
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
            <div style="padding-left: 0px;" class="col-sm-12">
                <div class="col-md-4">
                    <div class="contadorAtd"></div>
                </div>
                    <div class="col-md-2 centralizar">
                        <i class='fa fa-heartbeat'></i> ID Atendimento 
                    </div>
                    <div class="col-md-2 centralizar">
                        <i class='fa fa-credit-card'></i> Convênio 
                    </div>
                    <div class="col-md-2 centralizar">
                        <i class='fa fa-calendar-check-o'></i> Data Atendimento 
                    </div>
                    <div class="col-md-2 centralizar">
                        <i class='fa fa-clock-o'></i> Previsão Entrega
                    </div>
            </div>
            <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter"></ul>  
        </div>
    </div>
    @include('layouts.includes.base.modalSeachAtendimento')
@stop

@section('statusFooter')
    <span class='statusFinalizados'></span> Finalizados <span class='statusAguardando'></span> Parc. Finalizado
    <span class='statusEmAndamento'></span> Em Processo <span class='statusPendencias'></span> Existem Pendências
    <span class='statusNaoRealizado'></span>Em Andamento

    <span class="pull-right">
        <span class="pull-left">
        </span>
        <a href="{{url()}}/sobre" target="_blank">
            {!! Html::image(config('system.experienceLogo'), 'logo_exp', array('title' => 'eXperience - codemed','id'=>'logoRodape','style'=>'margin-right:8px')) !!}
        </a>
    </span>
    <span class="pull-right"><i class='fa fa-keyboard-o'></i> <b>SHIFT+Z: </b> Localizar Atendimento</span>
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/pikaday/pikaday.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/js-cookie/js.cookie.js') }}"></script>

    <script src="{{ asset('/assets/js/experience/async.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-grey',
            });

            if(Cookies.get('cabecalho') == null){
                var cabecalho = '{{config("system.impressaoTimbrado")}}';
                Cookies.set('cabecalho',cabecalho);
            }

            if(Cookies.get('cabecalho') == 1){
                $('#checkTimbrado').iCheck('check');                
            }

            $('#checkTimbrado').on('ifChecked', function (event){
                Cookies.set('cabecalho',1);  
            });

            $('#checkTimbrado').on('ifUnchecked', function (event){
                Cookies.set('cabecalho',0);    
            });

            var picker = new Pikaday({ 
                field: $('.datepicker')[0],
                format: 'DD/MM/YYYY', 
                maxDate: moment().toDate(), 
            });
            var picker2 = new Pikaday({ 
                field: $('.datepicker')[1],
                format: 'DD/MM/YYYY', 
                maxDate: moment().toDate(), 
            });

            VMasker($("#dataInicio")).maskPattern('99/99/9999');
            VMasker($("#dataFim")).maskPattern('99/99/9999');


            //Abre filtro quando ta reduzido
            $(".menu-trigger").click(function() {
               $(".boxFiltroPosto").slideToggle(768, function() {
                   $(this).toggleClass("nav-expanded").css('display', '');
               });
            });  
            
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
                $('#situacao').val('');
                $('#postoRealizante').val('');
            }

            //Configura o componente de lista
            $('#listFilter').slimScroll({
                height: '63vh',
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
                $('#btnFiltrar').removeClass('not-active');

                if(txt == 'Todos'){
                     $(selecthashtag).css('background-color','white');
                }else{
                     $(selecthashtag).css('background-color','#CFECCF');
                }
            });

            $("#dataInicio,#dataFim").on("change",function (){ 
                $('#btnFiltrar').removeClass('not-active');

                getItensFiltro();

            });

            function getItensFiltro(){
                var postAcomodacao = [
                    {name:'dataInicio', 'value' : $('#dataInicio').val()},
                    {name:'dataFim', 'value' : $('#dataFim').val()}
                ];
                
                var async = new AsyncClass();
                var dataResultAcomodacao = async.run('{{url("/")}}/posto/selectacomodacao',postAcomodacao,'POST');

                dataResultAcomodacao.then(function(result){
                    var selectAcomodacao = $('#acomodacao');
                    selectAcomodacao.empty();

                    $.each(result.data,function(key,value){
                        selectAcomodacao.append($("<option/>").val(key).text(value));
                    });
                    
                    $('#acomodacao').val(Cookies.get('acomodacao'));
                    //Dispara o evento do botao click para iniciar a busca inicial
                    $("#acomodacao option:first").attr('selected','selected');
                    
                    var async = new AsyncClass();

                    var posto = '{{Auth::user()['posto']}}';
                    var postPostoRealizante = [
                        {name:'posto', 'value' : posto},
                        {name:'dataInicio', 'value' : $('#dataInicio').val()},
                        {name:'dataFim', 'value' : $('#dataFim').val()}
                    ];

                    var dataResultPostoRealizante = async.run('{{url("/")}}/posto/selectpostorealizante',postPostoRealizante,'POST');
                    
                    dataResultPostoRealizante.then(function(result){
                        var selectPostoRealizante = $('#postoRealizante');
                        selectPostoRealizante.empty();


                        selectPostoRealizante.append($("<option/>").val('').text('Todos'));

                        $.each(result.data,function(key,value){
                            selectPostoRealizante.append($("<option/>").val(key).text(value));
                        });
                        
                        $('#postoRealizante').val(Cookies.get('postoRealizante'));
                        //Dispara o evento do botao click para iniciar a busca inicial            
                        $("#postoRealizante option:first").attr('selected','selected');
                        
                        $('#btnFiltrar').trigger('click');
                    });
                    
                });
            }

            //Evento do disparo do botão de filtro
            $('#btnFiltrar').click(function(e){
                Cookies.set('dataInicio', $('#dataInicio').val());
                Cookies.set('dataFim', $('#dataFim').val());
                Cookies.set('acomodacao', $('#acomodacao').val());
                Cookies.set('situacao', $('#situacao').val());
                Cookies.set('postoRealizante', $('#postoRealizante').val());

                if($('#dataInicio').val() == '' || $('#dataFim').val() == ''){
                    swal("Datas Não Preenchidas..", "Atençao, preencha os campos de Data(Inicial e Final), Para selecionar um periodo de tempo para qual deseja visualizar os atendimentos.", "warning"); 
                    return false;
                }

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
                        $('.contadorAtd').html('<h5 styçe="margin-bottom: 0px;" class="achouAtd">'+result.data.length+' ocorrências para o filtro selecionado.</h5>');
                        //Prepara htmk do LI
                        var item = '<li class="col-sm-12 boxatendimento '+atendimento.situacaoAtendimento+'"data-key="'+atendimento.key+'" data-atendimento="'+atendimento.atendimento+'" data-posto="'+atendimento.posto+'">'+
                            '<div class="row">'+
                                '<div class="col-md-4 col-sm-6 col-xs-12">'+
                                    '<strong>'+atendimento.nome+'</strong>'+'<br>'+'<i class="'+((atendimento.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> '+atendimento.idade+
                                '</div>'+
                                '<div class="centralizar col-md-2 col-sm-6 col-xs-6">'+
                                    '<span data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"><strong> '+atendimento.posto+'/'+atendimento.atendimento+'</strong></span>'+                                                    
                                '</div>'+
                                '<div class="centralizar col-md-2 col-sm-6 col-xs-6">'+
                                    '<span data-toggle="tooltip" data-placement="bottom" title="Convênio"> '+atendimento.nome_convenio+
                                '</span></div>'+
                                '<div class="centralizar col-md-2 col-sm-6 col-xs-6 hidden-xs">'+
                                    '<span data-toggle="tooltip" data-placement="bottom" title="Data do Atendimento"> '+atendimento.data_atd+
                                '</span></div>';

                        if(atendimento.situacao_exames_experience != 'TF' && atendimento.data_entrega != false && atendimento.data_entrega != null){
                           item += '<div class="centralizar col-md-2 col-sm-6 col-xs-12">'+
                                    '<span data-toggle="tooltip" data-placement="bottom" title="Previsão de entrega"> '+atendimento.data_entrega+
                            '</span></div>';
                        }
                        
                        item += '<div class="col-md-12 col-sm-6 col-xs-12">'+
                                    '<span data-toggle="tooltip" data-placement="bottom" title="Exames"><i class="fa fa-flask"></i> '+atendimento.mnemonicos+
                                '</span></div>'+
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

            getItensFiltro();
        });
    </script>
@stop