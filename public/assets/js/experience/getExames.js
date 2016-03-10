function getExames(url,posto,atendimento){
	$.get(url+"/paciente/examesatendimento/"+posto+"/"+atendimento, function( result ) {

	  $.each( result.data, function( index, exame ){
	    conteudo = '';
	    checkbox = '&nbsp;&nbsp;&nbsp;&nbsp;';
	    visualizacao = '<div id="boxExame" data-visualizacao="N">';
	    impressao = '';
	    corStatus = '';

	    console.log(exame);

	    if(exame.class == 'success-element' && exame.tipo_entrega == '*'){
	      checkbox = '<input checked id="todo'+index+'" type="checkbox">';
	      visualizacao = '<div id="boxExame" data-visualizacao="OK">';
	    }

	    if(exame.tipo_entrega != '*'){
	      impressao = '<span class="tipoEntregaImpressao">Este exame só poderá ser impresso no laboratorio</span>';
	    }

	    conteudo = '<div class="row todo-element '+exame.class+'">'+
	                  '<div class="col s2">'+
	                      /*checkbox+*/
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