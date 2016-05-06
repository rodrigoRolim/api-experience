if (window.history && window.history.pushState) {

	window.history.pushState('', null, '');

	$(window).on('popstate', function() { // Botão voltar do navegador pressionado
	  swal({   title: "Deseja sair do sistema?",   
	  text: "Confirme clicando no botão sair.",   
	  type: "warning",   
	  showCancelButton: true,   confirmButtonColor: "#DD6B55",   
	  cancelButtonText: "Cancelar",
	  confirmButtonText: "Sair",   closeOnConfirm: false }, 
	  function()
	  {  
	    window.location = '/auth/logout'; 
	  });
	});

}