function ExamesClass(){}

ExamesClass.prototype.get = function(url,tipoAcesso,posto,atendimento){
    var objResult = Object();
    var async = new AsyncClass();
    
    return async.run(url+"/"+tipoAcesso+"/examesatendimento/"+posto+"/"+atendimento);
}

ExamesClass.prototype.render = function(result,saldoDevedor,dataMsg, tipo = 'DEFAULT'){
    var html = '';
    $('.listaExames').html('');
    $('.boxSelectAll').html('');

    if(result.data == ''){
        html = '<div style="text-align:center;"><h2>Não foram realizados exames para este atendimento</h2></div>';
        return html;
    }
    
    $.each( result.data, function(index,exame){
        var check = '';        
        var msg = '';
        var opacity = '';
        var amostra = '';

        var situacaoExame = exame.class;

        $('#atendimento').html(exame.posto +'/'+ exame.atendimento);

        var visualiza = false;

        if(exame.tipo_entrega == "*"){
            visualiza = true;
        
            if(saldoDevedor){
                opacity = 'opacity:0.6';
                exame.class += ' semHover';
                visualiza = false;
            }

            if(exame.class != 'success-element'){
                visualiza = false;
            }
        }else{
            msg = dataMsg['tipoEntregaInvalido'];
            opacity = 'opacity:0.6';
        }

        if(situacaoExame == 'danger-element' && Number(exame.amostra) > 0){
            exame.msg += ' <span style="color: orange">(Nova amostra solicitada)</span>';
        }

        if(Number(exame.amostra) > 0){
            amostra += "<i data-toggle='tooltip'";
            amostra += "data-placement='right' title='Nova Amostra' class='fa fa-flask amostra'></i> ";
        }

        
        if(visualiza){
            $('.boxSelectAll').html('<span><input type="checkbox" class="checkAll"></span>');
            check = "<div class='i-checks checkExames' data-posto='"+exame.posto+"' data-atendimento='"+exame.atendimento+"'><input type='checkbox' class='check' value='"+exame.correl+"'></div>";
        }
        
        html += "<div class='col-md-6 boxExames' style='"+opacity+"' data-visu='"+visualiza+"' data-correl='"+exame.correl+"' data-atendimento='"+exame.atendimento+"' data-posto='"+exame.posto+"'>";
        html += "<li class='"+exame.class+" animated fadeInDownBig'>"+check;
        html += "<div class='dadosExames'>";
        html += "<b>"+exame.mnemonico+"</b> | "+exame.nome_procedimento.trunc(31)+"<br>"+amostra+exame.msg+"<br>";
        
        if(tipo != 'DEFAULT'){
            html += "<div class='postoRealizante'> <span data-toggle='tooltip' data-placement='right' title='Posto Realizante'><i class='fa fa-hospital-o'></i> ";
            html += exame.nome_posto_realizante+" "+(exame.tipo_posto_realizante == 'A' ? '(Lab. Apoio)' : '')+"</span></div><span class='msgExameTipoEntrega'>"+msg+"</span>";
        }

        html += "</li></div>";
    });

    return html;
}


ExamesClass.prototype.detalheExame = function(url,tipoAcesso,posto,atendimento,corel){
    var async = new AsyncClass();
    return async.run(url+"/"+tipoAcesso+"/detalheatendimentoexamecorrel/"+posto+"/"+atendimento+"/"+corel);
}

ExamesClass.prototype.renderDetalheExame = function(exame,msgAmostra){
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
                            if(Number(exame.AMOSTRAS) > 0){
                                result['table'] += '<tr><td colspan="2" class="text-center">'+msgAmostra+'</td></tr>';                                  
                            }
    result['table'] += '</table>';
    return result;
}