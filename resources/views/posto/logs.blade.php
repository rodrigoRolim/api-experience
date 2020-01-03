@extends('layouts.layoutBase')

@section('stylesheets')
    {!! Html::style('/assets/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/assets/css/plugins/sweetalert/sweetalert.css') !!}
    @parent
@stop

@section('infoHead')
    <div class="media-body">        
        <button data-toggle="dropdown" class="btn btn-usuario dropdown-toggle boxLogin">
            <span class="font-bold"><strong>{{Auth::user()['nome']}}</strong></span> <span class="caret"></span><br>
        </button>         
        <ul class="dropdown-menu pull-right itensInfoUser">
            <li class="item imprimirTimbrado"><input id="checkTimbrado" type="checkbox"></i>&nbsp; Imprimir Cabeçalho</li>
            <li style="border-bottom:1px solid #efefef; margin-top:8px"></li>          
            <li class="item"><a href="{{url()}}/auth/logout"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </div>    
@stop

@section('content')
    <div class="wrapper wrapper-content">
        <div class="ibox-content">
            <h2>Monitoramento DataSnap</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">DATA</th>
                        <th scope="col">POSTO</th>
                        <th scope="col">ATENDIMENTO</th>
                        <th scope="col">CORRELS</th>
                        <th scope="col">ERROR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td width="180px">{{\Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $log->created_at)->format('d/m/Y H:s:i')}}</td>
                            <td>{{$log->mon_posto}}</td>
                            <td>{{$log->mon_atendimento}}</td>
                            <td width="180px">{{$log->mon_correls}}</td>
                            <td>{{$log->mon_error}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop