<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>
      Alterar Senha
    </title>
    <meta content="IE=edge" http-equiv="x-ua-compatible">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    {!! Html::style('/assets/css/plugins/asteroid/materialdesignicons.min.css') !!}
    {!! Html::style('/assets/css/plugins/asteroid/keyframes.css') !!}  
    {!! Html::style('/assets/css/plugins/asteroid/materialize.min.css') !!}
    {!! Html::style('/assets/css/plugins/asteroid/style.css') !!}
    {!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
    {!! Html::style('/assets/css/customMobile.css') !!}

</head>
  <body>
    <div class="m-scene" id="main"> <!-- Page Container -->
    @if(Auth::user()['tipoAcesso'] == 'MED')
       @include('mobile.medico.includes.menu')
    @else
       @include('mobile.paciente.includes.left')
    @endif
      <!-- Page Content -->
      <div class="snap-content news z-depth-5" id="content">
        <!-- Toolbar -->
        <div id="toolbar">
            <div class="row navbar-fixed">
            <div class="open-left">
              <i id="open-left" class="mdi mdi-sort-variant"></i>
            </div>
            <span class="title nomePaciente">{{Auth::user()['nome']}}
                <i id="open-right" class="mdi-filter-outline"></i><br> </span>
            @if(Auth::user()['tipoAcesso'] == 'MED')
            <input id="acesso" type="hidden" value="MED">
             <span class="infoPaciente"> 
                  {{Auth::user()['tipo_cr']}}-{{Auth::user()['uf_conselho']}}:{{Auth::user()['crm']}}
             </span>
            @endif
           </div>
        </div>

        <!-- Main Content -->
        <div class="scene_element scene_element--fadeinup">

        <div id="alterarSenha">
	       	<div class="row">
			    <form id="formSenha" class="col s12">
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="senhaAtual" name="senhaAtual" type="password" class="validate">
			          <label for="password">Senha Atual</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="novaSenha" name="novaSenha" type="password" class="validate">
			          <label for="password">Nova Senha</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="confirmarSenha" name="confirmarSenha" type="password" class="validate">
			          <label for="password">Confirmar Nova Senha</label>
			        </div>
			      </div>
			      <div class="row right-align">
					 <button class="btn waves-effect red lighten-2" id="btnSalvarPerfil">Salvar
					    <i class="material-icons right"></i>
					  </button>			        
			      </div>			      
			    </form>
			  </div>
		  </div>
          
          <!-- Footer -->
          <div class="scene_element scene_element--fadeinup footer-copyright secondary-color">
            <div class="container">
              Desendolvido por <a style="color:white" href="http://www.codemed.com.br">Codemed</a>
            </div>
          </div>

        </div> <!-- End of Main Contents -->
        <div id="blockui"></div>
      </div> <!-- End of Page Content -->
    </div> <!-- End of Page Container -->

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/materialize.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/snap.js') }}"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/sidebar.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/functions.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/validate/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getClientes.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/eventoBotaoSairNavegador.js') }}"></script>

  </body>
</html>

<script type="text/javascript">


	$('.mdi-filter-outline').hide();

	$(document).ready(function(){

		var form = $('#formSenha');
    $('#open-right').hide();
                
            form.validate({
                rules: {
                    senhaAtual: {
                        required: true
                    },
                    novaSenha: {
                        required: true,
                        minlength: 6,
                        maxlength:15
                    },
                    confirmarSenha: {
                        required: true,
                        equalTo: "#novaSenha",
                        minlength: 6,
                        maxlength:15
                    }
                },
            });

            urlPerfil = '{{url()}}/paciente/alterarsenha';

            tipoAcesso = $('#acesso').val();

            if(tipoAcesso == 'MED'){
              urlPerfil = '{{url()}}/medico/alterarsenha';
            }

             $('#btnSalvarPerfil').click(function(e){                                          

                if(form.valid()){
                    //serializa dos dados do formulario
                    var postData = form.serializeArray();
                    $.ajax({
                        url : urlPerfil,
                        type: 'POST',
                        data : postData,
                        success:function(data, textStatus, jqXHR) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);
                            var style = (jqXHR['status'] == 200 ? 'success':'danger');
                            if(msg.message == 'Senha atual não confere'){
                            	swal("", msg.message , "error");  
                            }
                            else{
                            	swal("", msg.message , "success");  
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);

                            swal("", msg.message , "error");    
                        }
                    });
                }else{
                    swal("", "Preencha os Dados Corretamente ", "erro");  
                }

                e.preventDefault();                
            });



	});

</script>