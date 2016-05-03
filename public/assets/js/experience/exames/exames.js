function ExamesClass(){}

ExamesClass.prototype.get = function(url,tipoAcesso,posto,atendimento){
    var objResult = Object();
    var async = new AsyncClass();
    
    return async.run(url+"/"+tipoAcesso+"/examesatendimento/"+posto+"/"+atendimento);
}

ExamesClass.prototype.render = function(result,saldoDevedor,dataMsg){
    var html = '';
    
    $.each( result.data, function(index,exame){
        var check = '';        
        var msg = '';
        var opacity = '';
        $('#solicitante').html(nomeSolicitante);
        $('#atendimento').html(strPad(exame.posto + '/' + exame.atendimento));
        var visualiza = false;

        if(exame.tipo_entrega == "*" && exame.class == "success-element" && !saldoDevedor){
            $('.boxSelectAll').html('<span><input type="checkbox" class="checkAll"></span>');
            check = "<div class='i-checks checkExames' data-posto='"+exame.posto+"' data-atendimento='"+exame.atendimento+"'><input type='checkbox' class='check' value='"+exame.correl+"'></div>";
            visualiza = true;
        }

        if(exame.tipo_entrega != "*"){
            msg = dataMsg['tipoEntregaInvalido'];
            exame.class = 'success-elementNoHov';
            opacity = 'opacity:0.6';
        }

        if(saldoDevedor){
            exame.class = 'success-elementNoHov';
        }
        
        html += "<div class='col-md-6 boxExames' style='"+opacity+"' data-visu='"+visualiza+"' data-correl='"+exame.correl+"' data-atendimento='"+exame.atendimento+"' data-posto='"+exame.posto+"'>";
        html += "<li class='"+exame.class+" animated fadeInDownBig'>"+check;
        html += "<div class='dadosExames'>";
        html += "<b>"+exame.mnemonico+"</b> | "+exame.nome_procedimento.trunc(31)+"<br>"+exame.msg+"<br>";
        html += "<div class='postoRealizante'> <span data-toggle='tooltip' data-placement='right' title='Posto Realizante'><i class='fa fa-hospital-o'></i> ";
        html += exame.nome_posto_realizante+" "+(exame.tipo_posto_realizante == 'A' ? '(Lab. Apoio)' : '')+"</span></div><span class='msgExameTipoEntrega'>"+msg+"</span></li></div>";
    });

    return html;
}


ExamesClass.prototype.detalheExame = function(url,tipoAcesso,posto,atendimento,corel){
    var async = new AsyncClass();
    return async.run(url+"/"+tipoAcesso+"/detalheatendimentoexamecorrel/"+posto+"/"+atendimento+"/"+corel);
}

ExamesClass.prototype.renderDetalheExame = function(exame){
    var result = [];

    result['title'] = exame.PROCEDIMENTO;
    result['table'] = '<table id="tabelaDetalhes" class="table table-striped">';
                            $.each( exame.ANALITOS, function(index,analito){
                                var valorAnalito = analito.VALOR;

                                if(!isNaN(valorAnalito)){
                                    var valorAnalito = Math.round(analito.VALOR);
                                    valorAnalito = valorAnalito.toFixed(analito.DECIMAIS);
                                }

                                result['table'] += '<tr>';
                                result['table'] +=     '<td class=" analitos">'+analito.ANALITO+'</td>';
                                result['table'] +=     '<td class="valoresAnalitos">';
                                result['table'] +=         '<strong>'+valorAnalito+' '+(analito.UNIDADE == 'NULL'?'':analito.UNIDADE)+'</strong>';
                                result['table'] +=     '</td>';
                                result['table'] +=  '</tr>';
                            });
                            
                            result['table'] += '<tr><td id="finalDetalhamento" colspan="2">Liberado em '+exame.DATA_REALIZANTE+' por '+exame.REALIZANTE.NOME+' - '+ exame.REALIZANTE.TIPO_CR+' '+exame.REALIZANTE.UF_CONSELHO+' : '+exame.REALIZANTE.CRM+' Data e Hora da Coleta: '+exame.DATA_COLETA+'</td></tr>';
    result['table'] += '</table>';
    return result;
}