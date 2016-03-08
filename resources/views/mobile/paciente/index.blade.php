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
          <span class="title">Exames</span>
<!--           <div class="open-right" id="open-right">
            <i class="mdi mdi-dots-vertical"></i>
          </div> -->
        </div>
        
        <!-- Main Content -->
        <div class="scene_element scene_element--fadeinup">

          <div class="page-header bg-14">
            <div class="overlay-gradient">
            </div>
            <h2 class="white-text" style="font-size: 20px; margin-bottom:0px;  text-shadow: -0.2px 0 black, 0 0.2px black, 1px 0 black, 0 -0.2px black;">
              {{Auth::user()['nome']}}
            </h2>

            <ul class="tabs">
              <li class="tab col s6">
              @foreach($atendimentos as $key => $atendimento)
                <a class="active" style="font-size: 10px;"> {{ date('d/m/Y',strtotime($atendimento->data_atd))}} | Atendimento: {{$atendimento->atendimento}} {{$atendimento->nome_convenio}}</a>
              @endforeach
              </li>
            </ul>
          </div>
                <div class="areaLegendaExames">
                    <div class="infoExame" style="color:black; font-size:0.6em;">
                      <span class="statusFinalizados"></span>&nbsp;Finalizados 
                      <span class="statusAguardando"></span>&nbsp;Em Andamento 
                      <span class="statusEmAndamento"></span>&nbsp;Pendentes 
                      <span class="statusPendencias"></span>&nbsp;Nao Realizados 
                    </div>
                </div>

          <div class="col s12 todo" id="test1">
            <p class="todo-element border-left-coral">
              <input id="todo1" type="checkbox"> <label for="todo1">HBS | ANTIGENO AUSTRALIA (HBS AG)</label> <span>&nbsp;Nao Realizado &nbsp;|&nbsp;&nbsp;Centro</span>
            </p>

            <p class="todo-element border-left-sea">
              <input checked id="todo2" type="checkbox"> <label for="todo2">APE | ANTIGENO PROSTATICO ESPECIFICO</label> <img alt=""> <span>&nbsp;Finalizado &nbsp;|&nbsp;&nbsp;Centro</span>
            </p>

            <p class="todo-element border-left-coral">
              <input id="todo5" type="checkbox"> <label for="todo5">HC | HEMOGRAMA AUTOMATIZADO</label> <span>&nbsp;Nao Realizado &nbsp;|&nbsp;&nbsp;Centro/span> <img alt="">
            </p>

            <p class="todo-element border-left-sea">
              <input checked id="todo6" type="checkbox"> <label for="todo6">GLI | GLICEMIA EM JEJUM</label> <span>&nbsp;Finalizado &nbsp;|&nbsp;&nbsp;Centro</span>
            </p>

            <p class="todo-element border-left-sea">
              <input checked id="todo7" type="checkbox"> <label for="todo7">LIC | LIPIDOGRAMA COMPLETO</label> <img alt="" > <span>&nbsp;Finalizado &nbsp;|&nbsp;&nbsp;Centro</span>
            </p>

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

  </body>
</html>

