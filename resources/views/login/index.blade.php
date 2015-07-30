<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> Resultados Online </title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Use the correct meta names below for your web application
       Ref: http://davidbcalhoun.com/2010/viewport-metatag 
       
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    {!! Html::style('/assets/css/bootstrap.min.css') !!}

    {!! Html::style('/assets/css/font-awesome.min.css') !!}    

    <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->

    {!! Html::style('/assets/css/smartadmin-production.css') !!} 

    <!-- ***** VERIFICAR onde smartadmin-skins é aplicado ***** -->
    {!! Html::style('/assets/css/smartadmin-skins.css') !!}  
   
     <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

  </head>
  <body id="login" class="animated fadeInDown">
    <!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
    <header id="header">
      <!--<span id="logo"></span>-->

      <div id="logo-group">
        {!! Html::image('/assets/images/logo.png', 'SmartAdmin', array('title' => 'Logomarca')) !!}          

        <!-- END AJAX-DROPDOWN -->
      </div>

    </header>

    <div id="main" role="main">

      <!-- MAIN CONTENT -->
      <div id="content" class="container">

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
            <h1 class="txt-color-red login-header-big">Code Med</h1>
            <div class="hero">

              <div class="pull-left login-desc-box-l">
                <h4 class="paragraph-header">Resultados Online - eXperience</h4>
                <div class="login-app-icons">
                  <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                  <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                </div>
              </div>
              
              
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
                <p>
                  Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
                </p>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="about-heading">Not just your average template!</h5>
                <p>
                  Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
                </p>
              </div>
            </div>

          </div>
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
            <div class="well no-padding">
              <form action="index.html" id="login-form" class="smart-form client-form">
                <header>
                  Log in
                </header>

                <fieldset>
                  
                  <section>
                    <label class="label">Atendimento</label>
                    <label class="input"> <i class="icon-append fa fa-user"></i>
                      <input type="email" name="email">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Informe o ID/Numero do Atendimento</b></label>
                  </section>

                  <section>
                    <label class="label">Senha</label>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                      <input type="password" name="password">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Informe a senha do atendimento</b> </label>                    
                  </section>

                  <section>
                    <label class="checkbox">
                      <input type="checkbox" name="remember" checked="">
                      <i></i>Manter-se Conectado</label>
                  </section>
                </fieldset>
                <footer>
                  <button type="submit" class="btn btn-primary">
                    Entrar
                  </button>
                </footer>
              </form>

            </div> 
          </div> <!-- Fim da DIV de Login -->


          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
            <div class="well no-padding">
              <form action="index.html" id="login-form" class="smart-form client-form">
                <header>
                  Posto
                </header>

                <fieldset>
                  
                  <section>
                    <label class="label">Posto</label>
                    <label class="input"> <i class="icon-append fa fa-user"></i>
                      <input type="email" name="email">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Informe o Numero do Posto</b></label>
                  </section>

                  <section>
                    <label class="label">Senha</label>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                      <input type="password" name="password">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Informe a senha de acesso do posto</b> </label>                    
                  </section>

                  <section>
                    <label class="checkbox">
                      <input type="checkbox" name="remember" checked="">
                      <i></i>Manter-se Conectado</label>
                  </section>
                </fieldset>
                <footer>
                  <button type="submit" class="btn btn-primary">
                    Entrar
                  </button>
                </footer>
              </form>

            </div> 
          </div> <!-- Fim da DIV de Login -->

          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
            <div class="well no-padding">
              <form action="index.html" id="login-form" class="smart-form client-form">
                <header>
                  Médico
                </header>

                <fieldset>
                  
                  <section>
                    <label class="label">Atendimento</label>
                    <label class="input"> <i class="icon-append fa fa-user"></i>
                      <input type="email" name="email">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Informe o ID/Numero do Atendimento</b></label>
                  </section>

                  <section>
                    <label class="label">Senha</label>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                      <input type="password" name="password">
                      <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Informe a senha do atendimento</b> </label>                    
                  </section>

                  <section>
                    <label class="checkbox">
                      <input type="checkbox" name="remember" checked="">
                      <i></i>Manter-se Conectado</label>
                  </section>
                </fieldset>
                <footer>
                  <button type="submit" class="btn btn-primary">
                    Entrar
                  </button>
                </footer>
              </form>

            </div> 
          </div> <!-- Fim da DIV de Login -->

        </div>
      </div>

    </div>