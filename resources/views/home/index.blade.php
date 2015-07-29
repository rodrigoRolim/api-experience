<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th style="width: 120px;text-align: left">POSTO</th>
        <th style="text-align: left">ATENDIMENTO</th>
        <th style="text-align: left">CORREL</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($exames as $exame)
            <tr>
                <td>{{ $exame['posto']}}</td>
                <td>{{ $exame['atendimento']}}</td>
                <td>{{ $exame['correl']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>