<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Paciente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/framework.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="js/webfont.js"></script>
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

<body>
    <section class="w-section mobile-wrapper">
        <div class="page-content" id="main-stack">
        <?php
   			include 'menuTeste.blade.php';
        ?>
            <div class="body">
                <div class="paciente-image">
                    <div class="paciente-image-title">
                        <h4 class="nomePaciente">Ailton Nunes De Morais Rego</h4>
                        <div class="sub-title-small">&nbsp;40 anos 4 meses 9 dias &nbsp;|&nbsp;&nbsp;000/052013  Unihosp</div>
                    </div>
                    <div class="paciente-image-img"><img src="images/photo-1429032021766-c6a53949594f.jpg"> </div>
                </div>
                <div class="text-new">
	                <a class="w-inline-block link-blog-list" data-load="1"> 
	                	<h2 class="title-new text-center"></h2>
	                	<div class="infoExame" style="color:black">&nbsp;&nbsp;&nbsp;
		                	<span class="statusFinalizados"></span>&nbsp;Finalizados 
		                	<span class="statusAguardando"></span>&nbsp;Em Andamento 
		                	<span class="statusEmAndamento"></span>&nbsp;Pendentes 
		                	<span class="statusPendencias"></span>&nbsp;Não Realizados 
	                	</div>
                </div>
                <ul class="list">
                    <li class="list-item grey highlighted boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list highlighted">HBS | ANTIGENO AUSTRALIA (HBS AG)</div>
                            <div class="infoExame" style="color:black">&nbsp;Finalizado &nbsp;|&nbsp;&nbsp;Centro</div>
                        </a>
                    </li>
                    <li class="list-item finalizado boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list">ANTIGENO PROSTATICO ESPECIFICO</div>
                        </a>
                    </li>
                    <li class="list-item finalizado boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list">CRE | CREATININA </div>
                        </a>
                    </li>
                    <li class="list-item grey highlighted boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list highlighted">VDRL | SOROLOGIA PARA LUES (VDRL)</div>
                            <div class="infoExame" style="color:black">&nbsp;Em Andamento &nbsp;|&nbsp;&nbsp;Matriz</div>
                        </a>
                    </li>
                    <li class="list-item finalizado boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list">HC | HEMOGRAMA AUTOMATIZADO </div>
                            <div class="infoExame" style="color:black">&nbsp;Finalizado &nbsp;|&nbsp;&nbsp;Centro</div>
                        </a>
                    </li>

                        <li class="list-item pendente boxPaciente" data-ix="list-item">
                            <a class="w-clearfix w-inline-block" href="#popupBasic" data-rel="popup">
                                <div id="checkExame" class="icon-list highlighted">
                                    <div class="icon ion-ios-checkmark-empty"></div>
                                </div>
                                <div class="title-list">GLI | GLICEMIA EM JEJUM</div>
                            </a>
                        </li>

                    <li class="list-item grey highlighted boxPaciente" data-ix="list-item">
                        <a class="w-clearfix w-inline-block" href="#">
                            <div id="checkExame" class="icon-list highlighted">
                                <div class="icon ion-ios-checkmark-empty"></div>
                            </div>
                            <div class="title-list highlighted">LIC | LIPIDOGRAMA COMPLETO </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-content loading-mask" id="new-stack">
            <div class="loading-icon">
                <div class="navbar-button-icon icon ion-load-d"></div>
            </div>
        </div>
        <div data-role="popup" id="popupBasic">
          <p>This is a completely basic popup, no options set.</p>
        </div>
    </section>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/framework.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>

</html>

<script type="text/javascript">
    
    $(".boxPaciente").click(function(){
        $(this).find("#checkExame").toggleClass("highlighted finalizado");
    });

</script>

