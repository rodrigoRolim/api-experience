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
     @include('mobile.paciente.includes.modalexame')
  <body>
    <div class="m-scene" id="main"> <!-- Page Container -->

     @include('mobile.paciente.includes.menu')
      <!-- Page Content -->
      <div class="snap-content z-depth-5" id="content">

        <!-- Toolbar -->
        <div id="toolbar">
          <div class="open-left" id="open-left">
            <i class="mdi mdi-sort-variant"></i>
          </div>          
          <div class="row">
            <span class="title nomePaciente">{{Auth::user()['nome']}} <br> </span>
             <span class="infoPaciente"> 
             Data do Atendimento: {{ date('d/m/Y',strtotime($atendimentos[0]->data_atd))}} - Atendimento: {{$atendimentos[0]->atendimento}}
             </span>
           </div>
<!--           <div class="open-right" id="open-right">
            <i class="mdi mdi-dots-vertical"></i>
          </div> -->
        </div>
        
        <!-- Main Content --> 
        <div class="scene_element scene_element--fadeinup">
<!-- 
          <div>
            <ul class="tabs">
              <li class="tab col s6">
              @foreach($atendimentos as $key => $atendimento)
                <a class="active" style="font-size: 10px;"> {{ date('d/m/Y',strtotime($atendimento->data_atd))}} | Atendimento: {{$atendimento->atendimento}} {{$atendimento->nome_convenio}}</a>
              @endforeach
              </li>
            </ul>
          </div>
 -->
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

  </body>
</html>

<script type="text/javascript">

$(document).ready(function(){

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
        if(visualizacao == 'OK')
          $('#modal').openModal();  
    })

});
          


</script>

