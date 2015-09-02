<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title></title>

    {!! Html::style('/assets/css/bootstrap.min.css') !!}

    {!! Html::style('/assets/css/animate.css') !!}
    {!! Html::style('/assets/css/inspinia.css') !!}
    {!! Html::style('/assets/css/custom.css') !!}
    {!! Html::style('/assets/css/skins/red.css') !!}

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    @section('stylesheets')
        {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}
        @parent
    @show
</head>

<body class="boxed-layout">
    <div id="wraper">
        <div class="container">
            <div id="header">
                <nav class="navbar navbar-static-top headLogin headPadrao" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header logo">
                        {!! Html::image('/assets/images/logo.png', 'logo_lab', array('title' => 'logo')) !!}
                    </div>
                    <div class="feed-element pull-right infoUser">
                        @yield('infoHead')
                    </div>
                </nav>
            </div>
        </div>
        <div class="container">
            <div id="wrapper">
                @yield('left')
                <div id="page-wrapper" class="gray-bg" style="min-height: 85.6vh;">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

@section('script')
    <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('li:first-child').addClass('active');

            $('.metismenu li i').attr('style','display:none');

            resizeDisplay();

            $('.navbar-minimalize').click(function () {
                $("body").toggleClass("mini-navbar");
            });

            $(window).bind("resize", function () {
                resizeDisplay();
            });

            function resizeDisplay(){
                if ($(this).width() < 769) {
                    $('body').addClass('body-small');
                    $('body').addClass('mini-navbar');
                    $('.metismenu li b').attr('style','display:1');
                } else {
                    $('body').removeClass('body-small');
                    $('body').removeClass('mini-navbar');
                    $('.metismenu li b').attr('style','display:none');
                }
            }

            $('li').click(function(event) {
               $('li').not(this).removeClass('active clicked');    /// Alternancia de fundos ao clicar/selecionar um atendimento da lista. (linhas 63-66).           
               $('li').not(this).addClass('notClicked');
               $(this).toggleClass('active clicked');
               $(this).toggleClass('notClicked');  
            });  
        });
    </script>
@show