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
            <div class="row navbar-fixed">
            <div class="open-left">
              <i id="open-left" class="mdi mdi-sort-variant"></i>
            </div>
            <span class="title nomePaciente">{{Auth::user()['nome']}}
                <i id="open-right" class="mdi-filter-outline"></i><br> </span>
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
  <script src="{{ asset('/assets/js/plugins/moments/moments.js') }}"></script>
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

     var snapper = new Snap({
      element: document.getElementById('content')
    });

    snapper.open('right');
    $('#open-right').toggleClass("mdi-filter-outline mdi-chevron-left ");

    $('#open-left').click(function(e){ 
        if(snapper.state().state == 'left')
          $('.snap-drawer-left').hide();
        else
          $('.snap-drawer-left').show();
    });

    $('#open-right').click(function(e){ 
        if(snapper.state().state == 'right'){
          $('#open-right').toggleClass("mdi-chevron-left mdi-filter-outline");
          $('.snap-drawer-right').hide();
        }
        else{
          $('#open-right').toggleClass("mdi-filter-outline mdi-chevron-left ");
          $('.snap-drawer-right').show();
        }
    });

    var dataInicio = new moment();
    var dataFim = new moment();
    var qtdDiasFiltro = {{config('system.medico.qtdDiasFiltro')}}; 

    dataInicio = dataInicio.subtract(qtdDiasFiltro,'days');
    dataInicio = dataInicio.format('YYYY-MM-DD');
    dataFim = dataFim.format('YYYY-MM-DD');   

    $('#dataInicio').val(dataInicio);
    $('#dataFim').val(dataFim);

    $('#dataInicio').prop("max",dataFim);
    $('#dataFim').prop("min",dataInicio);
    $('#dataFim').prop("max",dataFim);

    $('#comboPeriodos').change(function(){ 
      var periodo = $('#comboPeriodos option:selected');
      periodo = periodo.val();
      
      var dataInicio = new moment();

      switch (periodo) {
        case 'Ultimos 3 dias':
            dataInicio = dataInicio.subtract(3,'days');
            dataInicio = dataInicio.format('YYYY-MM-DD');
          break;
        case 'Ultimos 5 dias':
            dataInicio = dataInicio.subtract(5,'days');
            dataInicio = dataInicio.format('YYYY-MM-DD');
          break;
        case 'Ultimos 15 dias':
            dataInicio = dataInicio.subtract(15,'days');
            dataInicio = dataInicio.format('YYYY-MM-DD');
          break;         
      }

      $('#dataInicio').val(dataInicio);
    });

    $('#btnFiltrar').click(function(e){    

        $('#listaPacientes').html('');     

        $('#listaPacientes').html('');              

        var formMedico = $('#formMedico :input');
        var formData = formMedico.serializeArray();

        dataInicio = new moment(formData[0].value);
        dataFim = new moment(formData[1].value);
        dataInicio = dataInicio.format('DD/MM/YYYY');
        dataFim = dataFim.format('DD/MM/YYYY');

        formData[0].value = dataInicio;
        formData[1].value = dataFim;

        formData.push({name: 'posto', value: ''});
        formData.push({name: 'convenio', value: ''});
        formData.push({name: 'situacao', value: ''});

        url = "{{url('/')}}";            
        getClientes(url,formData);
        snapper.close();
        $('.snap-drawer-right').hide();
        $('#open-right').toggleClass("mdi-chevron-left mdi-filter-outline");

    });


  });

</script>