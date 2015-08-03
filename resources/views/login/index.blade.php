@extends('layouts.layoutLogin')

@section('content')


<body class="gray-bg">
	<div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6">
                <h2>
                    <span class="text-navy">INSPINIA - Responsive Admin Theme</span>
                	<br><br>is provided with two main layouts 
                    <br>three skins and separate configure options.
                </h2>
                <p>
                    Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                </p>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                </p>
            </div>
            <div class="col-md-6">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tabLoginPaciente" aria-expanded="true">Paciente</a></li>
                        <li class=""><a data-toggle="tab" href="#tabLoginPosto" aria-expanded="false">Posto</a></li>
                        <li class=""><a data-toggle="tab" href="#tabLoginMedico" aria-expanded="false">Médico</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabLoginPaciente" class="tab-pane active">
                            <div class="panel-body">
                                Paciente
                                <form class="m-t" role="form" action="index.html">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Username" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" placeholder="Password" required="">
                                    </div>
                                    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
                                </form>
                            </div>
                        </div>
                        <div id="tabLoginPosto" class="tab-pane">
                            <div class="panel-body">
                                Posto
                                <form class="m-t" role="form" action="index.html">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Username" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" placeholder="Password" required="">
                                    </div>
                                    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
                                </form>
                            </div>
                        </div>
                        <div id="tabLoginMedico" class="tab-pane">
                            <div class="panel-body">
                                Médico
                                <form class="m-t" role="form" action="index.html">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Username" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" placeholder="Password" required="">
                                    </div>
                                    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@stop