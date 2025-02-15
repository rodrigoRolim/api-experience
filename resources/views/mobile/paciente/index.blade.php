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

    <div class="navbar-fixed">
      <nav>
          <div class="open-left-alt openAlt">
            <i id="open-left-alt" class="mdi mdi-sort-variant"></i>
          </div>
            <div id="areaInformacoesPaciente-alt">         
              @if(Auth::user()['tipoAcesso'] == 'MED')
              <span class="title nomePaciente">{{$atendimentos[0]->nome}}
              @else
              <span class="title nomePaciente">{{Auth::user()['nome']}}
              @endif
                  <i id='close-right-alt' class="mdi-information-outline infoAlt"></i><br> </span>
               <span class="infoPaciente"> 
               Data do Atendimento: <span id="dataAtendimentoPacienteAlt">{{$atendimentos[0]->data_atd}} </span>
               </span>
             </div>
      </nav>
    </div>

    <div class="m-scene" id="main"> <!-- Page Container -->
     @include('mobile.paciente.includes.menu')
      <!-- Page Content -->
      <div class="snap-content z-depth-5" id="content">
        <!-- Toolbar -->
        <div id="toolbar">
          <div class="row navbar">
          <div class="open-left">
            <i id="open-left" class="mdi mdi-sort-variant"></i>
          </div>
            <div id="areaInformacoesPaciente">         
              @if(Auth::user()['tipoAcesso'] == 'MED')
              <span class="title nomePaciente">{{$atendimentos[0]->nome}}
              @else
              <span class="title nomePaciente">{{Auth::user()['nome']}}
              @endif
                  <i id='close-right' class="mdi-information-outline"></i><br> </span>
               <span class="infoPaciente"> 
               Data do Atendimento: <span id="dataAtendimentoPaciente">{{$atendimentos[0]->data_atd}} </span>
               </span>
             </div>
           </div>
        </div>

        <!-- Main Content --> 
        <div id="contentPrincipal" class="scene_element scene_element--fadeinup">

        <div id="semExames"></div>
        <div id="existemPendencias"></div>
          <div class="col s12 todo" id="listaExames" style="position: relative;"></div>
          <div id="containerBtnResultados" class="hide">
           <button id="pdfResultados" class="btn-floating btn-large waves-effect waves-light red"><i class="mdi-download"></i></button>            
          </div>
        </div> <!-- End of Main Contents -->


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
  <script src="{{ asset('/assets/js/plugins/asteroid/sidebar.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/asteroid/functions.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getExames.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/getDescricaoExames.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/eventoBotaoSairNavegador.js') }}"></script>
  <script src="{{ asset('/assets/js/experience/exportarPdf.js') }}"></script>


  </body>
</html>

<script type="text/javascript">

$(window).scroll(function() {

    if ($(this).scrollTop()>0)
     {
        $('.navbar-fixed').fadeIn();
        $('.navbar').fadeOut();
     }
    else
     {
      $('.navbar-fixed').fadeOut();
      $('.navbar').fadeIn();
     }

 });

$(document).ready(function(){
    $('.navbar-fixed').fadeOut();

    var tipoAcesso = '{{Auth::user()['tipoAcesso']}}';
    var url = '{{url('/')}}';

    if(tipoAcesso == 'PAC'){
        tipoAcesso = 'paciente';
    }

    if(tipoAcesso == 'MED'){
        tipoAcesso = 'medico';
    }


    var exportandoPdf = false;

    var snapper = new Snap({
      element: document.getElementById('content')
    });

    $('#gerarPdfMenu').hide();

    $('.btnAtendimento').first().addClass('active');

    $('#listaAtendimentos .btnAtendimento').on('click', function(){
        $(selector).removeClass('active');
        $(this).addClass('active');
    });

    $('#gerarPdfMenu').on('click', function(){
        $('#gerarPdfMenu').toggleClass('active');
    })

    $('#open-left').click(function(e){ 
        if(snapper.state().state == 'left')
          $('.snap-drawer-left').hide();
        else
          $('.snap-drawer-left').show();
    });

    $('#open-left-alt').click(function(e){ 
       $('#open-left').click();
    });
    
    $('.btnAtendimento').click(function(e){ 
        posto = $(e.currentTarget).data('posto');
        atendimento = $(e.currentTarget).data('atendimento');
        mnemonicos = $(e.currentTarget).data('mnemonicos');
        tipoAcesso = $(e.currentTarget).data('acesso');
        dataAtendimento = $(e.currentTarget).data('dtatendimento');
        dataEntrega = $(e.currentTarget).data('entrega');
        indice = $(e.currentTarget).data('indice');
        solicitante = $(e.currentTarget).data('solicitante');
        convenio = $(e.currentTarget).data('convenio');
        saldo = $(e.currentTarget).data('saldo');   

        if(tipoAcesso == 'MED')
          tipoAcesso = 'medico';
        else
          tipoAcesso = 'paciente';

        if($('#gerarPdfMenu').attr('class') == 'active'){
          $('#containerBtnResultados').toggleClass("hide");
          $('#gerarPdfMenu').toggleClass('active');
        }

        var listaInfo = '<ul class="collection">'+
                          '<li id="idAtendimento" class="collection-item center-align"></li>'+
                         '<li id="previsaoAtd" class="collection-item left-align bkfInfo"><b>PREVISÃO DE ENTREGA:</b><br></li>'+
                          '<div id="convenioAtd" class="collection-item left-align bkfInfo"><b>CONVÊNIO:</b><br></div>'+
                          '<li id="solicitanteAtd" class="collection-item left-align bkfInfo"><b>MÉDICO SOLICITANTE:</b><br></li>'+
                        '</ul>';



        $('.modal-content').html(''); 
        $('.modal-content').append(listaInfo);
        $('#idAtendimento').append('<strong>ID:</strong> <span>0'+posto+'/'+atendimento+' </span><br>'); 
        $('#idAtendimento').append('<strong> </strong><span>'+dataAtendimento+' </span>');
        $('#previsaoAtd').append('<span class="right-align"> '+dataEntrega+' </span>'); 
        $('#convenioAtd').append('<span class="right-align"> '+convenio+' </span>'); 
        $('#solicitanteAtd').append('<span class="right-align">'+solicitante+'</span>'); 



        if(mnemonicos == ""){ 
            $('#gerarPdfMenu').hide(); 
            $('#listaExames').html('');  
            $('#semExames').html('');
            $('#existemPendencias').html('');
            $('#dataAtendimentoPaciente').text(dataAtendimento);
            $('#dataAtendimentoPacienteAlt').text(dataAtendimento);                   
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
            $('#existemPendencias').html('');
            if(saldo != 0){
             $('#existemPendencias').append('<p class="todo-element center-align ">'+
              '<label class="pendencias">Existem Pendências.</label>'+
            '</p>');            
            }
            $('#dataAtendimentoPaciente').text(dataAtendimento); 
            $('#dataAtendimentoPacienteAlt').text(dataAtendimento);  
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
        switch(visualizacao) {
          case 'OK':
              if(!exportandoPdf){
                $('#tabelaDetalhes').html('<div class="loader">Loading...</div>{!!config("system.messages.loadingExameMobile")!!}');
                getDescricaoExame(url,dadosExames,tipoAcesso);
                $('#modalDetalhamento').openModal({
                    dismissible: false, // Modal can be dismissed by clicking outside of the modal
                    in_duration: 300, // Transition in duration
                    out_duration: 200, // Transition out duration
                  });                
              }
              break;
          case 'P': //Tipo entrega diferente de *
               swal("Atenção", "Este exame só poderá ser impresso no laboratório", "error");
               break;
          case 'S': // Saldo Devedor
               swal("Atenção", "Existêm Pendências", "warning");
               break;
          case 'N':
               swal("Atenção", "Exame Não Realizado", "warning");    
               break;      
        }

    })

     $('#areaInformacoesPaciente, #areaInformacoesPaciente-alt').click(function(e){
          $('#modal').openModal();
     });

     $('.btnFecharDetalhamento').click(function(e){
          $('#modalDetalhamento').closeModal();
          $('.modal-titulo').html('');
          $('#rodapeDetalhe').html('');
          $('#dvPdfDetalhe').html('');
     });

     $('#gerarPdfMenu').click(function(e){
          $('#open-left').trigger('click');
          $('.checkResults').toggleClass("hide");
          $('#containerBtnResultados').toggleClass("hide");
          exportandoPdf ^= true; //Funciona como um toggle, que alterna a variavel entre TRUE e FALSE
     });

     $('#pdfResultados').click(function(e){
        var checkboxes = $('input:checked');       
            var correl = [];
               checkboxes.each(function () {
                    correl.push($(this).data('correl'));
                  });   
            if(correl.length == 0){
              swal('','Selecione ao menos um Exame para exportação para o arquivo PDF.','error');
            }
            var cabecalho = true; 
            var paginaPdf = window.open('/impressao', '', ''); 
             exportPdf(url,tipoAcesso,posto,atendimento,correl,'G',cabecalho,paginaPdf);
     });
});  

</script>
