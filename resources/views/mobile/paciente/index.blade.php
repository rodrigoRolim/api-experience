<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>
      Paciente
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
     @include('mobile.paciente.includes.modInfo')
  <body>
    <div class="m-scene" id="main"> <!-- Page Container -->

     @include('mobile.paciente.includes.menu')
      <!-- Page Content -->
      <div class="snap-content z-depth-5" id="content">
        <!-- Toolbar -->
        <div id="toolbar">
          <div class="row navbar-fixed">
          <div class="open-left">
            <i id="open-left" class="mdi mdi-sort-variant"></i>
          </div>         
          
            <span class="title nomePaciente">{{$atendimentos[0]->nome}}
                <i id='close-right' class="mdi-information-outline"></i><br> </span>
             <span class="infoPaciente"> 
             Data do Atendimento: <span id="dataAtendimentoPaciente">{{ date('d/m/Y',strtotime($atendimentos[0]->data_atd))}} </span>
             </span>
           </div>
<!--           <div class="open-right" id="open-right">
            <i class="mdi mdi-dots-vertical"></i>
          </div> -->
        </div>
        
        <!-- Main Content --> 
        <div id="contentPrincipal" class="scene_element scene_element--fadeinup">
          <div class="col s12 todo" id="listaExames">
          </div>
        </div> <!-- End of Main Contents -->

        <div id="semExames"></div>

          <!-- Footer -->
<!--           <footer class="scene_element scene_element--fadeinup footer-copyright secondary-color">
            <div class="container">
              Desendolvido por <a href="http://www.codemed.com.br">Codemed</a>
            </div>
          </footer> -->

        <div id="blockui"></div>
      </div> <!-- End of Page Content -->
    </div> <!-- End of Page Container -->

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/materialize.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/snap.js') }}"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/jquery.smoothState.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/sidebar.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/functions.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getExames.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getDescricaoExames.js') }}"></script>

  </body>
</html>

<script type="text/javascript">

$(document).ready(function(){

    var snapper = new Snap({
      element: document.getElementById('content')
    });

    var selector = '#listaAtendimentos .btnAtendimento';
    $('.btnAtendimento').first().addClass('active');

    $(selector).on('click', function(){
        $(selector).removeClass('active');
        $(this).addClass('active');
    });

    $('#open-left').click(function(e){ 
        if(snapper.state().state == 'left')
          $('.snap-drawer-left').hide();
        else
          $('.snap-drawer-left').show();
    });

    $('.snap-drawer-right').hide();

    $('.btnAtendimento').click(function(e){ 
        posto = $(e.currentTarget).data('posto');
        atendimento = $(e.currentTarget).data('atendimento');
        mnemonicos = $(e.currentTarget).data('mnemonicos');
        tipoAcesso = $(e.currentTarget).data('acesso');
        dataAtendimento = $(e.currentTarget).data('dtatendimento');
        indice = $(e.currentTarget).data('indice');
        solicitante = $(e.currentTarget).data('solicitante');
        convenio = $(e.currentTarget).data('convenio');

        if(tipoAcesso == 'MED')
          tipoAcesso = 'medico';
        else
          tipoAcesso = 'paciente';

        $('.modal-content').html(''); 
        $('.modal-content').append('<h5 class="tituloModal">Detalhes Adicionais - Atendimento '+atendimento+' </h5>');
        $('.modal-content').append('<br><p>ID: '+atendimento+' </p>');
        $('.modal-content').append('<p>Convênio: '+convenio+' </p>');
        $('.modal-content').append('<p>Medico Solicitante: '+solicitante+' </p>');

        if(mnemonicos == ""){  
            $('#listaExames').html('');  
            $('#dataAtendimentoPaciente').text(dataAtendimento);                 
            $('#semExames').append('<p class="todo-element border-left-coral">'+
              '<label class="semExames">Não foram realizados exames para este atendimento.</label>'+
            '</p>');
            snapper.close();
            $('.snap-drawer-left').hide();
            return false;
        }

        if(posto != null && atendimento != null){
            $('#listaExames').html('');
            $('#semExames').html('');
            $('#dataAtendimentoPaciente').text(dataAtendimento); 
            getExames("{{url('/')}}",tipoAcesso,posto,atendimento);
        }

        snapper.close();
        $('.snap-drawer-left').hide();

    });

    $('.btnAtendimento').first().click();

    $(document).on('click', '#boxExame', function(){  //Evento de Click para Divs criadas Dinamicamente
          visualizacao = $(this).data('visualizacao');
          url = "{{url('/')}}";
          var dadosExames = $(this).data();


        if(visualizacao == 'OK'){
          $('#close-right').toggleClass("mdi-information-outline mdi-chevron-left ");
          getDescricaoExame(url,dadosExames);
          $('html, body').animate({ scrollTop: 0 }, 'slow'); //Ir para o topo da pagina
          $('.snap-drawer-right').show();
          snapper.open('right');
        }
    })

     $('.mdi-information-outline').click(function(e){

        if(e.target.className == 'mdi-information-outline'){
            $('#modal').openModal();
        }else{
          $('.snap-drawer-right').hide();
          snapper.close();
          $('#close-right').toggleClass("mdi-chevron-left mdi-information-outline");
        }
     });

});
          


</script>

