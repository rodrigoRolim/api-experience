function ExamesClass(){}

ExamesClass.prototype.get = function(url,tipoAcesso,posto,atendimento){
    var objResult = Object();
    var async = new AsyncClass();
    
    return async.run(url+"/"+tipoAcesso+"/examesatendimento/"+posto+"/"+atendimento);
}

ExamesClass.prototype.render = function(result,saldo,dataMsg){
    var html = '';
    
    $.each( result.data, function(index,exame){
        var check = '';        
        var msg = '';
        var opacity = '';
        var visualiza = false;

        if(exame.tipo_entrega == "*" && exame.class == "success-element" && (saldo == '' && saldo == 0)){
            visualiza = true;
            check = "<div class='i-checks checkExames' data-posto='"+exame.posto+"' data-atendimento='"+exame.atendimento+"'><input type='checkbox' class='check' value='"+exame.correl+"'></div>";
        }

        if(exame.tipo_entrega != "*"){
            msg = dataMsg['tipoEntregaInvalido'];
            exame.class = 'success-elementNoHov';
            opacity = 'opacity:0.6';
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
    var html = '';

    html =  '<div class="modal fade" id="modalExames" role="dialog">';
    html +=     '<div class="modal-dialog">';
    html +=         '<div class="modal-content">';
    html +=             '<div class="modal-header">';
    html +=                 '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    html +=                 '<h2 class="modal-title">'+exame.PROCEDIMENTO+'</h2>';
    html +=             '</div>';
    html +=             '<div class="modal-body" style="padding-left:10px;padding-right:10px;">';
    html +=                 '<table id="tabelaDetalhes" class="table table-striped">';
                                $.each( exame.ANALITOS, function(index,analito){
                                    var valorAnalito = analito.VALOR;

                                    if(!isNaN(valorAnalito)){
                                        var valorAnalito = Math.round(analito.VALOR);
                                        valorAnalito = valorAnalito.toFixed(analito.DECIMAIS);
                                    }

                                    html += '<tr>';
                                    html +=     '<td class=" analitos">'+analito.ANALITO+'</td>';
                                    html +=     '<td class="valoresAnalitos">';
                                    html +=         '<strong>'+valorAnalito+' '+(analito.UNIDADE == 'NULL'?'':analito.UNIDADE)+'</strong>';
                                    html +=     '</td>';
                                    html +=  '</tr>';
                                });
    html +=                 '</table>';
    html +=             '</div>';
    html +=             '<div class="modal-footer">';
    html +=                 '<div id="rodapeDetalhe" class="col-lg-10 col-md-10 col-sm-10"></div>';
    html +=                 '<div id="dvPdfDetalhe" class="col-lg-2 col-md-2 col-sm-2"></div>';
    html +=             '</div>';
    html +=         '</div>';
    html +=     '</div>';
    html += '</div>';

    return html;
}