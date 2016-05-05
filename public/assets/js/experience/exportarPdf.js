function exportPdf(url,tipoAcesso,posto,atendimento,correl,tipo){
    var dadosExportacao = {};                           
    dadosExportacao = [{'posto':posto,'atendimento':atendimento,'correlativos': {correl}}]; 
    var paginaPdf = window.open ('/impressao', '', '');              

    $.ajax({ 
     url: url+'/'+tipoAcesso+'/exportarpdf',
     type: 'post',
     data: {"dados" : dadosExportacao},
     success: function(data){   
            if(data != 'false'){
                paginaPdf.location = data;     
            }else{
                paginaPdf.close();
                swal("Problemas ao exportar o seus resultados, tente mais tarde.", "Tente novamente mais tarde!", "error");
            }             
       }
	 });    
}