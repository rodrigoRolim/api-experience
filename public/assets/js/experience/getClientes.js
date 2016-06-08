function getClientes(url,postData){

    $.ajax({
        url : url+'/medico/filterclientes',
        type: 'POST',
        data : postData,
        success:function(result){
            
            $.each( result.data, function( index ){
                var cliente = result.data[index];

                console.log(cliente);

                var item = '<li class="boxPaciente" style="border-bottom: 1px solid #e7e7e9;" data-key="'+cliente.key+'">'+				             
				              	'<div class="truncate"><strong>'+cliente.nome+'</strong><br>'+
				              	'<span style="font-family: Century Gothic, sans-serif;">'+
				              	'<i class="'+((cliente.sexo == "M")?"mdi-gender-male":"mdi-gender-female")+'"></i>'+ 
				                ''+cliente.idade+' <br> ' +
				                ' Ultimo atendimento em: '+cliente.atendimentos.slice(-1).pop()+'</div>'+ '</div>'+
				             '</li>';

                $('#listaPacientes').append(item);
               
            });
            $('#listaPacientes li').click(function(e){
                var key = $(e.currentTarget).data('key');
                window.location.replace(window.location.href+"/paciente/"+key);
            });            
            if(result.data.length == 0){
                $('.ui-filterable').hide(); 
                $('#listaPacientes').append('<blockquote><h5 class="center-align"> Não foram encontrados atendimentos para este periodo. </h5></blockquote>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            var msg = jqXHR.responseText;
            msg = JSON.parse(msg);
        }
    });
}