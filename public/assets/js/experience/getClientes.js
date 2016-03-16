function getClientes(url,postData){
/*    $('#listFilter').html('<br><br><br><br><h2 class="textoTamanho"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>');*/
    $.ajax({
        url : url+'/medico/filterclientes',
        type: 'POST',
        data : postData,
        success:function(result){


            $.each( result.data, function( index ){
                var cliente = result.data[index];
/*                $('.contadorAtd').html('<h5 class="achouAtd">Foram encontrados ' + result.data.length + ' atendimentos para as datas selecionadas   .</h5>');*/

                var item = '<li class="boxPaciente" style="border-bottom: 1px solid #e7e7e9;" data-key="'+cliente.key+'">'+				             
				              	'<div class="truncate"><strong>'+cliente.nome+'</strong><br>'+
				              	'<span style="font-family: Century Gothic, sans-serif;">'+
				              	'<i class="'+((cliente.sexo == "M")?"mdi-gender-male":"mdi-gender-female")+'"></i>'+ 
				                ''+cliente.idade+' <br> ' +
				                ' Atendimento: 38 12936 <i class="mdi-beaker"></i> Em: 28/08/2015</div>'+ '</div>'+
				             '</li>';

/*              var count = 0;
                
                $.each( cliente.atendimentos, function( index ){
                    count++;
                    var atendimento = cliente.atendimentos[index];
                    item += '<span class="labelAtendimentosClientes col-sm-3"><i class="fa fa-calendar-check-o" ></i> '+atendimento+"</span>";

                    if(count == 3){
                        return false;
                    }
                });*/

                $('#listaPacientes').append(item);
               
            });

            $('#listaPacientes li').click(function(e){
                var key = $(e.currentTarget).data('key');
                /*window.location.replace("{{url('/')}}/medico/paciente/"+key);*/
                window.location.replace(window.location.href+"/paciente/"+key);
            });
            
            if(result.data.length == 0){
                $('#listaPacientes').append('<h2>Não foram encontrados atendimentos.</h2>');
/*                $('.contadorAtd').html('');*/
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            var msg = jqXHR.responseText;
            msg = JSON.parse(msg);
/*            $('#msgPrograma').html('<div class="alert alert-danger alert-dismissable animated fadeIn">'+msg.message+'</div>');*/
        }
    });
}