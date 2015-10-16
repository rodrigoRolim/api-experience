<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
    <head>
        <title>Be right back.</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 60px;
                margin-bottom: 40px;
                color: #000;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
            	{!! Html::image('/assets/images/logo_g.png', 'Codemed', array('title' => 'logo', 'style' => 'height:120px')) !!}
                <div class="title">Página não encontrada</div>
            </div>
        </div>
    </body>
</html>
