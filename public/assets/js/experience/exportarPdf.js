function exportPdf(url,tipoAcesso,posto,atendimento,correl,tipo,cabecalho,paginaPdf){
    console.log(url)
    var dadosExportacao = {};                           
    dadosExportacao = [{'posto':posto,'atendimento':atendimento, 'tipo': tipo, 'correlativos': {correl},'cabecalho':cabecalho}];              
    $.ajax({ 
     url: url+'/'+tipoAcesso+'/exportarpdf',
     type: 'post',
     data: {"dados" : dadosExportacao},
     success: function(data){   
         console.log(data)
            if(data != 'false'){
                paginaPdf.location = data;     
            }else{
                paginaPdf.close();
                swal("Problemas ao exportar o seus resultados, tente mais tarde.", "Tente novamente mais tarde!", "error");
            }             

		return true;
       }
	 });    

    return true;
}
