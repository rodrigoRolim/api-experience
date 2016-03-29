function verificaSaldoDevedor(saldo){
    if(saldo == null || saldo == 0){
       return false;
    }
      return true;
} 

function getExames(url,tipoAcesso,posto,atendimento){

	$.get(url+'/'+tipoAcesso+'/examesatendimento/'+posto+'/'+atendimento, function( result ) {

	  $.each( result.data, function( index, exame ){
	    conteudo = '';
	    checkbox = '&nbsp;&nbsp;&nbsp;&nbsp;';
	    visualizacao = '<div id="boxExame" data-visualizacao="N" data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+'">';
	    impressao = '';
	    corStatus = '';

	    if(!verificaSaldoDevedor(saldo)){
		    if(exame.class == 'success-element' && exame.tipo_entrega == '*'){
		      checkbox = '<input id="todo'+index+'" type="checkbox" data-correl="'+exame.correl+'">';
		      visualizacao = '<div id="boxExame" data-visualizacao="OK" data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+'">';
		    }
		}

	    if(exame.tipo_entrega != '*'){
	      impressao = '<span class="tipoEntregaImpressao">Este exame só poderá ser impresso no laboratorio</span>';
	      visualizacao = '<div id="boxExame" data-visualizacao="P" data-correl="'+exame.correl+'" data-atendimento="'+exame.atendimento+'" data-posto="'+exame.posto+'">';
	    }

	    conteudo = '<div class="row todo-element '+exame.class+'">'+
	                  '<div class="col s2 checkResults hide">'+
	                      checkbox+
	                    '<label for="todo'+index+'"></label>'+ 
	                  '</div>'+
	                  '<div class="col s10">'+
	                    visualizacao+
	                    '<label for="todo'+index+'" class="nomeProcedimento">'+exame.mnemonico+' | '+exame.nome_procedimento+'</label>'+ 
	                    '<span class="subInfoExame"> <em class="'+exame.corStatus+'">'+exame.msg+'</em> | '+exame.nome_posto_realizante+'</span>'+
	                    impressao+
	                    '</div>'+                          
	                  '</div>'+

	                '</div>';

	    $('#listaExames').append(conteudo);

	  });

	}, "json" );

};