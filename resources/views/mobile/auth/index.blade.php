<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/manhattan/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="assets/manhattan/css/framework.css">
    <link rel="stylesheet" type="text/css" href="assets/manhattan/css/styles.css">
    <script src="assets/manhattan/js/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Montserrat:400,700"]
            }
        });
    </script>
    <script type="text/javascript" src="assets/manhattan/js/modernizr.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
    <link rel="apple-touch-icon" href="images/logo.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="assets/manhattan/css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <section class="w-section mobile-wrapper">
        <div class="page-content bg-gradient" id="main-stack" data-scroll="0">
            <div class="body padding">
                <div class="logo-login"></div>  
                <div class="bottom-section padding tabPaciente">
                	 @include('mobile.auth.includes.mobileLoginPaciente')
                </div>
                <div class="bottom-section padding tabMedico">
                	 @include('mobile.auth.includes.mobileLoginMedico')
                </div>
            </div>
        </div>
        <div class="page-content loading-mask" id="new-stack">
            <div class="loading-icon">
                <div class="navbar-button-icon icon ion-load-d"></div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="assets/manhattan/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/manhattan/js/framework.js"></script>
    <script type="text/javascript" src="assets/manhattan/js/scripts.js"></script>
</body>

</html>

<script type="text/javascript">
	$( document ).ready(function() {
    	$(".tabMedico").hide();
    	$(".formCliente").hide();

    	$("#linkMedico").click(function(){
			$(".tabPaciente").hide();
			$(".tabMedico").show();
		});

		$("#linkPaciente").click(function(){
			$(".tabMedico").hide();
			$(".tabPaciente").show();
		});

		$("#linkCliente").click(function(){
			$(".formPaciente").hide();
			$(".formCliente").show();
		});

		$("#linkClientePaciente").click(function(){
			$(".formCliente").hide();
			$(".formPaciente").show();
		});

		$("#linkClienteMedico").click(function(){
			$(".tabPaciente").hide();
			$(".tabMedico").show();
		});
	});
</script>