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
    <!-- {!! Html::style('/assets/css/new/base.css') !!} -->

    {!! Html::style('/assets/css/skins/'.config('system.skinPadrao')) !!}
    
    {!! Analytics::render() !!}
    
    <link rel="shortcut icon" href="{{url()}}/assets/images/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    @section('stylesheets')
        {!! Html::style('/assets/css/plugins/datapicker/datepicker.css') !!}
        {!! Html::style('/assets/css/plugins/pikaday/pikaday.css') !!}
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
                <div class="feed-element pull-right">
                    @yield('infoHead')
                </div>
            </nav>
        </div>

        <div class="container-app">
            @yield('content')
        </div>

        <div id="footer">
            @include('layouts.includes.base.footer')
        </div>
    </div>
</body>
@section('script')
    <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
@show