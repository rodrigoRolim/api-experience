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
            <span class="title nomePaciente">{{Auth::user()['nome']}}
                <i class="mdi-information-outline infoAdicionais"></i><br> </span>
             <span class="infoPaciente"> 
             Data do Atendimento: {{ date('d/m/Y',strtotime($atendimentos[0]->data_atd))}} 
             </span>
           </div>
<!--           <div class="open-right" id="open-right">
            <i class="mdi mdi-dots-vertical"></i>
          </div> -->
        </div>
        
        <!-- Main Content --> 
        <div class="scene_element scene_element--fadeinup">
          <div class="col s12 todo" id="listaExames">
          </div>

          <!-- Footer -->
          <div class="scene_element scene_element--fadeinup footer-copyright secondary-color">
            <div class="container">
              Desendolvido por <a href="http://www.codemed.com.br">Codemed</a>
            </div>
          </div>

        </div> <!-- End of Main Contents -->
        <div id="blockui"></div>
      </div> <!-- End of Page Content -->
    </div> <!-- End of Page Container -->

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/materialize.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/snap.js') }}"></script> 
  <script src="{{ asset('/assets/js/plugins/asteroid/jquery.smoothState.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/sidebar.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/functions.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getExames.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getDescricaoExames.js') }}"></script>

  </body>
</html>

<script type="text/javascript">

$(document).ready(function(){

    var snapper = new Snap({
      element: document.getElementById('content')
    });

    $('#btnAtendimento').click(function(e){ 
        posto = $(e.currentTarget).data('posto');
        atendimento = $(e.currentTarget).data('atendimento');
        mnemonicos = $(e.currentTarget).data('mnemonicos'); 

        if(mnemonicos == ""){                    
            swal("Não foram realizados exames para este atendimento.");
        }

        if(posto != null && atendimento != null){
            getExames("{{url('/')}}",posto,atendimento);
        }

    });

    $('#btnAtendimento').click();

    $(document).on('click', '#boxExame', function(){  //Evento de Click para Divs criadas Dinamicamente
          visualizacao = $(this).data('visualizacao');
          url = "{{url('/')}}";
          var dadosExames = $(this).data();

        if(visualizacao == 'OK'){
          getDescricaoExame(url,dadosExames);
          snapper.open('right');
        }
    })

     $('.infoAdicionais').click(function(e){
        $('.modal-content').html(''); 
        $('.modal-content').append('<h5 class="tituloModal">Detalhes Adicionais - Atendimento {{$atendimentos[0]->atendimento}} </h5>');
        $('.modal-content').append('<br><p>ID: {{$atendimentos[0]->atendimento}} </p>');
        $('.modal-content').append('<p>Convênio: {{$atendimentos[0]->nome_convenio}} </p>');
        $('.modal-content').append('<p>Medico Solicitante: {{$atendimentos[0]->nome_solicitante}} </p>');
        $('#modal').openModal();  
     });

});
          


</script>

