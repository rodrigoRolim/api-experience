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
     @include('mobile.paciente.includes.modDetalhes')
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
            @if(Auth::user()['tipoAcesso'] == 'MED')
            <span class="title nomePaciente">{{$atendimentos[0]->nome}}
            @else
            <span class="title nomePaciente">{{Auth::user()['nome']}}
            @endif
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
          <div class="col s12 todo" id="listaExames" style="position: relative;"></div>
          <div id="containerBtnResultados" class="center-align hide">
           <button id="pdfResultados" class="btn-floating btn-large waves-effect waves-light red"><i class="mdi-download"></i></button>            
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

    $('#gerarPdfMenu').hide();

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
    
    $('.btnAtendimento').click(function(e){ 
        posto = $(e.currentTarget).data('posto');
        atendimento = $(e.currentTarget).data('atendimento');
        mnemonicos = $(e.currentTarget).data('mnemonicos');
        tipoAcesso = $(e.currentTarget).data('acesso');
        dataAtendimento = $(e.currentTarget).data('dtatendimento');
        indice = $(e.currentTarget).data('indice');
        solicitante = $(e.currentTarget).data('solicitante');
        convenio = $(e.currentTarget).data('convenio');
        saldo = $(e.currentTarget).data('saldo');   

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
          getDescricaoExame(url,dadosExames);
          $('#modalDetalhamento').openModal();

        }else if(visualizacao == 'P'){
          swal("Erro", "Este exame só poderá ser impresso no laboratório", "error");
        }
    })

     $('.mdi-information-outline').click(function(e){
          $('#modal').openModal();
     });

     $('.btnFecharDetalhamento').click(function(e){
          $('#modalDetalhamento').closeModal();
     });

     $('#gerarPdfMenu').click(function(e){
          $('#open-left').trigger('click');
          $('.checkResults').toggleClass("hide");
          $('#containerBtnResultados').toggleClass("hide");
     });

     $('#pdfResultados').click(function(e){
        var checkboxes = $('input:checked');       
            var correl = [];
               checkboxes.each(function () {
                      correl.push($(this).data('correl'));
                  });   
            console.log(correl); 
            if(correl.length == 0){
              swal('','Selecione ao menos um Exame para exportação para o arquivo PDF.','error');
            } 
     });

});
        


</script>

