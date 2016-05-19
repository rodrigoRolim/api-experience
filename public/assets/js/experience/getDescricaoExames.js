function getDescricaoExame(url,dadosExames,tipoAcesso){ 
    $.ajax({
        url : url+'/'+tipoAcesso+'/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
        type: 'GET',                            
        success:function(result){
            if(result.data == null){  
           $('#modalExames').modal('hide');
                swal("Erro ao carregar descrição do exame..", "Não há resultados disponíveis para visualização.", "error");                                    
                return false;
            }      
            var descricao = result.data;  
            var analitos = result.data.ANALITOS;
            var conteudo = '';

            $('.modal-titulo').html('');
            $('#tabelaDetalhes').html('');
            $('.modal-titulo').append('&nbsp;&nbsp;'+descricao.PROCEDIMENTO); 
            
            $('#rodapeDetalhe').append('Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+' - '+
                descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Coletado em: '+descricao.DATA_COLETA);
            $('#dvPdfDetalhe').html('<a href="#" id="btnPdfDetalhe" data-correl="'+dadosExames.correl+'" data-posto="'+dadosExames.posto+'" data-atendimento="'+dadosExames.atendimento+'" class="btn btn-danger btnPdf">Gerar PDF</a>');  


            $.each( analitos, function( index ){

                switch(analitos[index].UNIDADE) {
                    case 'NULL':
                        analitos[index].UNIDADE = '';
                        break;                                                                      
                }       

                var valorAnalito = analitos[index].VALOR;
                if(!isNaN(valorAnalito)){
                    var valorAnalito = Math.round(analitos[index].VALOR);
                    valorAnalito = valorAnalito.toFixed(analitos[index].DECIMAIS);
                }

                 conteudo =  '<tr>'+
                                '<td class = "descricaoExames">'+
                             '<td class = "analitos">'+
                                ''+analitos[index].ANALITO+'</div>'+
                             '<td class = "valoresAnalitos">'+
                                '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong>'+
                             '</tr>';

                $('#tabelaDetalhes').append(conteudo);

            });             
       
            if(result.data.length == 0){
                $('.modal-conteudo').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('#tabelaDetalhes').html('');
            $('#tabelaDetalhes').append('<h5 class="center-align erroDescricao">Erro ao carregar Descrição do Exame.</h5>');
        }
    });
}