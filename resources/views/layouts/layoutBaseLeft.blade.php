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
  <!--   {!! Html::style('/assets/css/new/base.css') !!} -->
    
    {!! Html::style('/assets/css/skins/'.config('system.skinPadrao')) !!}

    {!! Analytics::render() !!}
    
    <link rel="shortcut icon" href="{{url()}}/assets/images/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    @section('stylesheets')
        {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}
        @parent
    @show
</head>

<body class="boxed-layout">
    <div id="wraper">
       <div id="col-md-12 header">
            <nav class="navbar navbar-static-top headLogin headPadrao" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header logo">
                    {!! Html::image(config('system.clienteLogo'), 'logo_lab', array('title' => 'logo')) !!}
                </div>
                <div class="feed-element pull-right infoUser">
                    @yield('infoHead')
                </div>
            </nav>
        </div>
        <div >
            <div id="wrapper">
                @yield('left')
                @yield('content')
            </div>
        </div>
    </div>
</body>

@section('script')
    <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
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

            $('.metismenu li').click(function(event) {
               $('.metismenu li').not(this).removeClass('active clicked');    /// Alternancia de fundos ao clicar/selecionar um atendimento da lista. (linhas 63-66).           
               $(this).attr('class','active clicked notClicked');
            });  
        });
    </script>
@show