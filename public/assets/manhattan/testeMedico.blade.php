<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Medico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/framework.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/plugins/jquery-mobile/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="css/nativedroid2.css" />
        <link rel="stylesheet" href="http://example.gajotres.net/iscrollview/mobiscroll-2.4.custom.min.css" />    
    <script src="/assets/js/jquery-2.1.1.js"></script>
    <script src="/assets/js/plugins/jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
    <script src="js/webfont.js"></script>
    <script src="http://example.gajotres.net/iscrollview/mobiscroll-2.4.custom.min.js"></script>        
    <script>
        WebFont.load({
            google: {
                families: ["Montserrat:400,700"]
            }
        });
    </script>
    <script type="text/javascript" src="js/modernizr.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
    <link rel="apple-touch-icon" href="images/logo.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="fonteMobile">
    <section class="w-section mobile-wrapper">
        <div class="page-content" id="main-stack">
        <?php
   			include 'menuTeste.blade.php';
        ?>
            <div class="body">
                <div class="paciente-image">
                    <div class="paciente-image-title">
                        <h4 class="nomePaciente">Dr: Ailton Medico</h4>
                        <div class="sub-title-small">&nbsp;01/01/1970 &nbsp;|&nbsp;&nbsp;CRM: 6436</div>
                    </div>
                    <div class="paciente-image-img"><img src="images/photo-1429032021766-c6a53949594f.jpg"> </div>
                </div>
                <div class="text-new">
	                <a class="w-inline-block link-blog-list"> 
	                	<h2 class="title-new"></h2>
						<fieldset style="color:black;" data-role="controlgroup" data-type="horizontal" data-mini="true">
						    <label for="select-choice-1">Select A</label>
	                        <select name="select-choice-1" id="select-choice-1b" data-native-menu="false">
	                            <option value="javascript">Posto</option>
	                            <option value="css">MATRIZ</option>
	                            <option value="html">PARTICULAR</option>
	                        </select>
						    <label for="select-choice-2">Select B</label>
                            <select name="select-choice-2" id="select-choice-2b" data-native-menu="false">
	                            <option value="javascript">Convênio</option>
	                            <option value="css">SUS</option>
	                            <option value="html">Particular</option>
                        	</select>
						    <label for="select-choice-3">Select C</label>
                            <select name="select-choice-3" id="select-choice-3b" data-native-menu="false">
	                            <option value="javascript">Situação</option>
	                            <option value="css">FINALIZADOS</option>
	                            <option value="html">PENDENTES</option>
                        	</select>
						</fieldset>
                </div>
                <ul class="listaPacientes" data-role="listview" data-filter="true" data-filter-placeholder="Buscar Paciente" data-filter-theme="a" data-inset="true">
				    <li class="boxPaciente" style="border-bottom: 1px solid #e7e7e9;"><div class="icon ion-male "> Francisco de Assis da Silva</div>
				     <span style="font-family: Century Gothic, sans-serif;">47 anos 4 meses 3 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> 
				     </li>
	
				    <li style="border-bottom: 1px solid #e7e7e9;">Francisco Jose Marques Lopes<br><span style="font-family: Century Gothic, sans-serif;">15 anos 9 meses 3 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li>
		
				    <li style="border-bottom: 1px solid #e7e7e9;">Jose Olivan de Carvalho Moura Junior<br><span style="font-family: Century Gothic, sans-serif;">23 anos 1 meses 4 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li>
				 
					<li style="border-bottom: 1px solid #e7e7e9;">Aparecida Augusta Da Silva<br><span style="font-family: Century Gothic, sans-serif;">85 anos 5 meses 3 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li>
				 
					<li style="border-bottom: 1px solid #e7e7e9;">Aparecida Lopes Da Cruz Nogueira<br><span style="font-family: Century Gothic, sans-serif;">23 anos 4 meses 30 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li>
				 
					<li style="border-bottom: 1px solid #e7e7e9;">Geranildes Medeiros Dos Santos<br><span style="font-family: Century Gothic, sans-serif;">17 anos 4 meses 3 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li> 
				 
					<li style="border-bottom: 1px solid #e7e7e9;">Gerri Adriano Fernandes Da Silva<br><span style="font-family: Century Gothic, sans-serif;">27 anos 4 meses 3 dias | (98) 91827-4542
				     	<div class="icon ion-erlenmeyer-flask"> 29/02/16 | 38 12936</div> </li> 
				
				</ul>
            </div>
        </div>
        <div class="page-content loading-mask" id="new-stack">
            <div class="loading-icon">
                <div class="navbar-button-icon icon ion-load-d"></div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/framework.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>

</html>

<script type="text/javascript">
	$('.navbar-title').text("Médico");
	$('.nav-menu-header').text("Dr. Ailton");
	$('.dropExames').hide();
	$('.examesMenu').hide();

	$(".boxPaciente").click(function(){
		console.log('Teste Click');
	});

     $('#demo').mobiscroll().date({
       //invalid: { daysOfWeek: [0, 6]},
        theme: 'android-ics',
        display: 'inline',
        mode: 'scroller',
        dateOrder: 'mm dd yy',
        dateFormat : "mm-dd-yy",
        minDate: new Date(2015,03,16),
        maxDate: new Date(2015,11,03),
        
   
    });  
     
  $("#demo").change(function(){
     getNextdate();
      });


</script>


