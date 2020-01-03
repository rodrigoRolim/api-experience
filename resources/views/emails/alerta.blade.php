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
            <tr>
                <td width="180px">{{\Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $log->created_at)->format('d/m/Y H:s:i')}}</td>
                <td>{{$log->mon_posto}}</td>
                <td>{{$log->mon_atendimento}}</td>
                <td width="180px">{{$log->mon_correls}}</td>
                <td>{{$log->mon_error}}</td>
            </tr>
        </tbody>
    </table>
</div>