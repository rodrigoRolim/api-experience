@extends('layouts.layoutBase')

@section('stylesheets')
{!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
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

@include('layouts.includes.base.modalSeachPacienteByMedico')

@section('statusFooter')
    <span class="pull-right"><i class="fa fa-keyboard-o"></i> <b>SHIFT+Z: </b> Localizar Paciente</span>
@stop

<button class="menu-trigger text-center"> <i class="fa fa-filter fa-2x"> </i> Filtrar Atendimentos </button>
    <div class="col-md-12 corPadrao boxFiltro">
        <form id="formMedico">
            <div class="col-md-3">
                <label class="textoBranco">Atendimentos por datas entre:</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control datepicker" id="dataInicio" name="dataInicio">
                    <span class="input-group-addon">até</span>
                    <input type="text" class="input-sm form-control datepicker" id="dataFim" name="dataFim">
                </div>
            </div>
            <div class="col-md-2">
                <label class="textoBranco" name="posto">Posto de Cadastro</label>
                {!! Form::select('posto', [], '', array('class' => 'form-control m-b', 'id'=>'posto')) !!}
            </div>
            <div class="col-md-3">
                <label class="textoBranco" name="convenio">Convênios</label>
                {!! Form::select('convenio', [], '', array('class' => 'form-control m-b', 'id'=>'convenio')) !!}
            </div>
            <div class="col-md-2">
                <label class="textoBranco" name="situacao">Situação</label>
                {!! Form::select('situacao', config('system.selectFiltroSituacaoAtendimento'), '', array('class' => 'form-control m-b', 'id'=>'situacao')) !!}
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

    @include('layouts.includes.base.modalAlterarSenha')
@stop

@section('script')
    @parent
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

            var padAtd = '{{config('system.atdMaskZeros')}}';
            var padPos = '{{config('system.postoMaskZeros')}}';

            $("#dataInicio,#dataFim").on("change",function (){ 
                $('#btnFiltrar').removeClass('not-active');
                getItensFiltro();
    
            });

            $("#convenio, #situacao, #posto").change(function(e) {
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

            function getItensFiltro(){
                var idMedico = '{{Auth::user()['id_medico']}}';
                var postConvenios = [
                    {name:'idMedico', 'value' : idMedico},
                    {name:'dataInicio', 'value' : $('#dataInicio').val()},
                    {name:'dataFim', 'value' : $('#dataFim').val()}
                ];
                
                var async = new AsyncClass();
                var dataResultConvenios = async.run('{{url("/")}}/medico/selectconvenios',postConvenios,'POST');

                dataResultConvenios.then(function(result){
                    var selectConvenio = $('#convenio');
                    selectConvenio.empty();

                    $.each(result.data,function(key,value){
                        selectConvenio.append($("<option/>").val(key).text(value));
                    });
                    
                    $('#convenio').val(Cookies.get('convenio'));
                    //Dispara o evento do botao click para iniciar a busca inicial
                    $('#convenio option:first').attr('value', '');
                    console.log($('#convenio').val());

                    $("#convenio option:first").attr('selected','selected');
                    
                    var async = new AsyncClass();

                    var postPostosCadastro = [
                        {name:'idMedico', 'value' : idMedico},
                        {name:'dataInicio', 'value' : $('#dataInicio').val()},
                        {name:'dataFim', 'value' : $('#dataFim').val()}
                    ];

                    var dataResultPostosCadastro = async.run('{{url("/")}}/medico/selectpostoscadastro',postPostosCadastro,'POST');
                    
                    dataResultPostosCadastro.then(function(result){
                        var selectPostosCadastro = $('#posto');
                        selectPostosCadastro.empty();


                        selectPostosCadastro.append($("<option/>").val('').text('Todos'));

                        $.each(result.data,function(key,value){
                            selectPostosCadastro.append($("<option/>").val(key).text(value));
                        });
                        
                        $('#posto').val(Cookies.get('posto'));
                        //Dispara o evento do botao click para iniciar a busca inicial            
                        $("#posto option:first").attr('selected','selected');
                        
                        $('#btnFiltrar').trigger('click');
                    });
                    
                });
            }

            $(".menu-trigger").click(function() {
                $(".boxFiltro").slideToggle(400, function() {
                    $(this).toggleClass("nav-expanded").css('display', '');
                });

            });            
           
            var dataInicio = new moment();
            var dataFim = new moment();
            var qtdDiasFiltro = {{config('system.medico.qtdDiasFiltro')}};    

            dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
            dataInicio = dataInicio.format('DD/MM/YYYY');
            dataFim = dataFim.format('DD/MM/YYYY');

            if(Cookies.get('dataInicio') != null){ // Se o filtro foi utilizado durante a sessao, filtro sera automaticamente preenchido. Se não, rececebe valores padrões.
                $('#dataInicio').val(Cookies.get('dataInicio'));  
                $('#dataFim').val(Cookies.get('dataFim'));
                $('#convenio').val(Cookies.get('convenio'));     
                $('#situacao').val(Cookies.get('situacao'));     
                $('#posto').val(Cookies.get('posto'));     
            }else{
                $('#dataInicio').val(dataInicio);
                $('#dataFim').val(dataFim);
            }         

            VMasker($("#dataInicio")).maskPattern('99/99/9999');
            VMasker($("#dataFim")).maskPattern('99/99/9999');

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

            $('#filtroPaciente').filterList();             

            $('#btnFiltrar').click(function(e){                
                Cookies.set('dataInicio', $('#dataInicio').val());
                Cookies.set('dataFim', $('#dataFim').val());
                Cookies.set('convenio', $('#convenio').val());
                Cookies.set('situacao', $('#situacao').val());
                Cookies.set('posto', $('#posto').val());

                if($('#dataInicio').val() == '' || $('#dataFim').val() == ''){
                    swal("Datas Não Preenchidas..", "Atençao, preencha os campos de Data(Inicial e Final), Para selecionar um periodo de tempo para qual deseja visualizar os atendimentos.", "warning"); 
                    return false;
                }

                var formMedico = $('#formMedico');
                var postData = formMedico.serializeArray();

                getClientes(postData);
            });

            // $('#btnFiltrar').trigger('click');

            function getClientes(postData){
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                
                console.log(postData);
                $.ajax({
                    url : '{{url("/")}}/medico/filterclientes',
                    type: 'POST',
                    data : postData,
                    success:function(result){
                        $('#listFilter').html('');

                        $.each( result.data, function( index ){
                            var cliente = result.data[index];
                            $('.contadorAtd').html('<h5 class="achouAtd">Foram encontrados ' + result.data.length + ' atendimentos para as datas selecionadas   .</h5>');

                            if(cliente.telefone != null){
                                cliente.telefone = '<span class="ajusteFonte"><i class="fa fa-phone"></i> '+cliente.telefone+' </span>'
                            }else{
                                cliente.telefone = '';
                            }

                            var item =   '<li class="col-md-12 col-sm-12 col-xs-12 " data-key="'+cliente.key+'">'+
                                            '<div class="col-md-4 col-sm-6 col-xs-12 dadosPaciente text-left">'+
                                                '<strong>'+cliente.nome+'</strong><br><i class="'+((cliente.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> &nbsp;'+cliente.idade+
                                            '</div>'+
                                            '<div class="col-md-2 col-sm-6 col-xs-12 hidden-xs text-left">'+cliente.telefone+'</div>'+
                                            '<div class="col-md-6 col-sm-12 col-xs-12 hidden-xs data-toggle="tooltip" data-placement="right" title="span"><Atendimento class=" ajusteFonte"></span>';
                            var count = 0;
                            
                            $.each( cliente.atendimentos, function( index ){
                                count++;
                                var atendimento = cliente.atendimentos[index];

                                var medAtd = atendimento.split("|");//separa data do atendimento de posto/atendimento
                                var dataAtd = medAtd[0];
                                var postoAtd = medAtd[1].split(" "); //separa posto e atendimento
                                postoAtd = postoAtd.filter(function(e){return e}); //remove espaços em branco

                                //Mascara em posto e atendimento
                                postoAtd[1] = padAtd.substring(0, padAtd.length - postoAtd[1].length) + postoAtd[1];
                                postoAtd[0] = padPos.substring(0, padPos.length - postoAtd[0].length) + postoAtd[0];

                                item += '<span class="labelAtendimentosClientes col-sm-3" data-toggle="tooltip" data-placement="bottom" title="Posto/Atendimento"><i class="fa fa-calendar-check-o" ></i> '+dataAtd+' <br> '+ postoAtd[0]+'/'+postoAtd[1]+"</span>";

                                if(count == 3){
                                    return false;
                                }
                            });

                            item += '</div></li>';

                            $('#listFilter').append(item);
                           
                        });

                        $('#listFilter li').click(function(e){
                            var key = $(e.currentTarget).data('key');
                            window.location.replace("{{url('/')}}/medico/paciente/"+key);
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
            getItensFiltro();
        });
    </script>
@stop
