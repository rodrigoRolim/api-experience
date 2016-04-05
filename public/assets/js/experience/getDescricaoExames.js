function getDescricaoExame(url,dadosExames){ 
    $.ajax({
        url : url+'/paciente/detalheatendimentoexamecorrel/'+dadosExames.posto+'/'+dadosExames.atendimento+'/'+dadosExames.correl+'',
        type: 'GET',                            
        success:function(result){
            if(result.data == null){  
            $('.modal-conteudo').html('');
            $('.modal-conteudo').append('<h5 class="center-align erroDescricao">Erro ao carregar Descrição do Exame.</h5>');                                  
                return false;
            }      
            var descricao = result.data;  
            var analitos = result.data.ANALITOS;
            var conteudo = '';

            $('.modal-titulo').html('');
            $('.modal-titulo').append('&nbsp;&nbsp;'+descricao.PROCEDIMENTO); 
            $('.modal-conteudo').html('');
            $('.modal-rodape').html('');
            $('.modal-rodape').append(' Liberado em '+descricao.DATA_REALIZANTE+' por '+descricao.REALIZANTE.NOME+ ' ' +
                descricao.REALIZANTE.TIPO_CR+' '+descricao.REALIZANTE.UF_CONSELHO+' : '+descricao.REALIZANTE.CRM+' Coletado em: '+descricao.DATA_COLETA);


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

                conteudo = '<div class ="row descricaoExames">'+
                             '<div class="col s7 m7 l7 analitos">'+
                                ''+analitos[index].ANALITO+'</div>'+
                             '<div class="col s5 m5 l5 valoresAnalitos">'+
                                '<strong>'+valorAnalito+' '+analitos[index].UNIDADE+'</strong></div>'+
                             '</div>';

                $('.modal-conteudo').append(conteudo);

            });             
       
            if(result.data.length == 0){
                $('.modal-conteudo').append('<h2 class="textoTamanho">Não foram encontrados atendimentos.</h2>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('.modal-conteudo').html('');
            $('.modal-conteudo').append('<h5 class="center-align erroDescricao">Erro ao carregar Descrição do Exame.</h5>');
        }
    });
}