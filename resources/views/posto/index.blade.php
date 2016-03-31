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
                {!! Form::select('acomodacao', $acomodacoes, '', array('class' => 'form-control m-b', 'id'=>'acomodacao')) !!}
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
            <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="filtroPaciente" placeholder="Localizar Paciente" class="form-control">
            </div>
            <div class="contadorAtd"></div>
            <ul class="sortable-list connectList agile-list ui-sortable" id="listFilter"></ul>  
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/listJs/list.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins/js-cookie/js.cookie.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            $.strPad = function(i,l,s) {
                var o = i.toString();
                if (!s) { s = '0'; }
                while (o.length < l) {
                    o = s + o;
                }
                return o;
            };

            $('#filtroPaciente').focus();

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

            $(".menu-trigger").click(function() {
                $(".boxFiltroPosto").slideToggle(768, function() {
                    $(this).toggleClass("nav-expanded").css('display', '');
                });

            });            
            
            var dataInicio = new moment();
            var dataFim = new moment();
            var qtdDiasFiltro = {{config('system.posto.qtdDiasFiltro')}};

            $('.input-daterange').datepicker({
                keyboardNavigation: true,                
                autoclose: true,
                format: "dd/mm/yyyy",  
                disableTouchKeyboard: true            
            });

            dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
            dataInicio = dataInicio.format('DD/MM/YYYY');
            dataFim = dataFim.format('DD/MM/YYYY');

            if(Cookies.get('dataInicio') != null){ // Se o filtro foi utilizado durante a sessao, filtro sera automaticamente preenchido. Se não, rececebe valores padrões.
                $('#dataInicio').val(Cookies.get('dataInicio'));  
                $('#dataFim').val(Cookies.get('dataFim'));
                $('#acomodacao').val(Cookies.get('acomodacao'));     
                $('#situacao').val(Cookies.get('situacao'));     
                $('#postoRealizante').val(Cookies.get('postoRealizante'));     
            }else{
                $('#dataInicio').val(dataInicio);
                $('#dataFim').val(dataFim);
            }            

            VMasker($("#dataInicio")).maskPattern('99/99/9999');
            VMasker($("#dataFim")).maskPattern('99/99/9999');

            $(".input-daterange").attr("autocomplete", "off");

            $('#listFilter').slimScroll({
                height: 'auto',
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
                Cookies.set('acomodacao', $('#acomodacao').val());
                Cookies.set('situacao', $('#situacao').val());
                Cookies.set('postoRealizante', $('#postoRealizante').val());

                var formPosto = $('#formPosto');
                var postData = formPosto.serializeArray(); 

                getClientes(postData);
            });

            $('#btnFiltrar').trigger('click');

            function getClientes(postData){
                $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');
                $.ajax({
                    url : '{{url("/")}}/posto/filteratendimentos',
                    type: 'POST',
                    data : postData,
                    success:function(result){
                        $('#listFilter').html('');
                        var dataAtendimento = [];
 
                        $.each( result.data, function( index ){
                            var atendimento = result.data[index];                           
                            $('.contadorAtd').html('<h5 class="achouAtd">Foram encontrados ' + result.data.length + ' atendimentos para as datas selecionadas   .</h5>');
                       
                            atendimento.telefone = atendimento.telefone.replace(/ /g,""); //Remove espaços
                            atendimento.posto = $.strPad(atendimento.posto, {{config('system.qtdCaracterPosto')}});
                            atendimento.atendimento = $.strPad(atendimento.atendimento, {{config('system.qtdCaracterAtend')}});
                            dataAtendimento = new moment(atendimento.data_atd);                            
                            dataAtendimento = dataAtendimento.format('DD/MM/YYYY');     
                            dataNascimento = new moment(atendimento.data_nas);
                            dataNascimento = dataNascimento.format('DD/MM/YYYY');  

                            switch(atendimento.situacao_exames_experience){
                                case 'EA':
                                    atendimento.situacao_exames_experience = 'warning-element'
                                    break;
                                case 'TF':
                                    atendimento.situacao_exames_experience = 'success-element'
                                    break;
                                case 'PF':
                                    atendimento.situacao_exames_experience = 'aguardando-element'
                                    break;
                                case 'EP':
                                    atendimento.situacao_exames_experience = 'danger-element'
                                    break;
                                default:
                                    atendimento.situacao_exames_experience = 'naoRealizado-element'
                                    break;
                            }                       

                            var item = '<li class="col-sm-12 boxatendimento '+atendimento.situacao_exames_experience+'"data-key="'+atendimento.key+'" data-atendimento="'+atendimento.atendimento+'">'+
                                            '<div class="row">'+
                                                '<div class="col-md-4 col-sm-6 col-xs-12">'+
                                                    '<strong>'+atendimento.nome+'</strong>'+'<br>'+'<i class="'+((atendimento.sexo == "M")?"fa fa-mars":"fa fa-venus")+'"></i> '+atendimento.idade+
                                                '</div>'+
                                                '<div class="col-md-2 col-sm-6 col-xs-6">'+
                                                    '<i class="fa fa-heartbeat" data-toggle="tooltip" data-placement="right" title="Posto/Atendimento"></i><strong> '+atendimento.posto+'/'+atendimento.atendimento+'</strong>'+                                                    
                                                '</div>'+
                                                '<div class="col-md-2 col-sm-6 col-xs-6">'+
                                                    '<i class="fa fa-calendar-check-o" data-toggle="tooltip" title="Data do Atendimento"></i> '+dataAtendimento+
                                                '</div>'+
                                                '<div class="col-md-2 col-sm-6 col-xs-6 hidden-xs">'+
                                                    '<i class="fa fa-credit-card" data-toggle="tooltip" title="Convênio"></i> '+atendimento.nome_convenio+
                                                '</div>'+
                                                '<div class="col-md-12 col-sm-6 col-xs-12">'+
                                                    '<i class="fa fa-flask" data-toggle="tooltip" title="Mnemônicos"></i> '+atendimento.mnemonicos+
                                                '</div>'+
                                            '</div>'+
                                       '</li>';


                            $('#listFilter').append(item);
                        });

                        $('#listFilter li').click(function(e){
                            var key = $(e.currentTarget).data('key');
                            var atendimento = $(e.currentTarget).data('atendimento');
                            window.location.replace("{{url('/')}}/posto/paciente/"+key+"/"+atendimento);
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
            //Area de texto do Footer
            $(".areaStatusAtendimentos").append("<span class='statusAtendimentos'></span>");
            $(".statusAtendimentos").append(" <span class='statusFinalizados'></span>&nbsp; Finalizados &nbsp;&nbsp;<span class='statusAguardando'></span> Parc. Finalizado");
            $(".statusAtendimentos").append("&nbsp;&nbsp;<span class='statusEmAndamento'></span> Em Andamento &nbsp;&nbsp;<span class='statusPendencias'></span> Existem Pendências");
            $(".txtRodape").append("<i class='fa fa-heartbeat'></i> Posto/Atendimento &nbsp;|&nbsp; <i class='fa fa-calendar-check-o'></i> Data do Atendimento");
            $(".txtRodape").append("&nbsp;| &nbsp;<i class='fa fa-credit-card'></i> Convênio &nbsp |&nbsp; <i class='fa fa-flask'></i>  Mnemônicos");
        });
    </script>
@stop