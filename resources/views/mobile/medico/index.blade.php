<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>
      Medico
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
    {!! Html::style('/assets/css/plugins/asteroid/jquery.mobile-1.4.5.min.css') !!}

</head>
  <body>
    <div class="m-scene" id="main"> <!-- Page Container -->

       @include('mobile.medico.includes.menu')

      <!-- Page Content -->
      <div class="snap-content news z-depth-5" id="content">

        <!-- Toolbar -->
        <div id="toolbar">
          <div class="open-left" id="open-left">
            <i class="mdi mdi-sort-variant"></i>
          </div>
            <div class="row navbar-fixed">
            <span class="title nomePaciente">{{Auth::user()['nome']}}
                <i id="open-right" class="mdi-filter-outline infoAdicionais"></i><br> </span>
             <span class="infoPaciente"> 
                  {{Auth::user()['tipo_cr']}}-{{Auth::user()['uf_conselho']}}:{{Auth::user()['crm']}}
             </span>
           </div>
        </div>

        <!-- Main Content -->
        <div class="scene_element scene_element--fadeinup">

        <ul id="listaPacientes" data-role="listview" data-filter="true" data-filter-placeholder="Buscar Paciente" data-filter-theme="a" data-inset="true">
  
        </ul>
          
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
  <script src="{{ asset('/assets/js/plugins/asteroid/jquery.smoothState.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/sidebar.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/functions.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/jquery.mobile-1.4.5.min.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getClientes.js') }}"></script>

  </body>
</html>

<script type="text/javascript">

  $(document).ready(function(){

    $('select').material_select();
    $("#convenio-button").removeClass(); //Alternativa para delegação arbitraria de classes pelo tema jquery mobile..
    $("#posto-button").removeClass();
    $("#situacao-button").removeClass();
    $("#btnFiltrar").removeClass("ui-btn");


    postData = [{name:"dataInicio", value:"09/03/2015"},{name:"dataFim", value:"14/03/2016"},
                {name:"posto", value:""},{name:"convenio", value:""},{name:"situacao", value:""}];

    url = "{{url('/')}}";            
    getClientes(url,postData);


  });

</script>