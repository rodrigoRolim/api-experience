<div class="modal fade" id="modalSeachPacienteByMedico" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="height: 131px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Localizar Paciente</h2>
                <div class="content"> 
                    <div class="row-fluid">
                        <div class="col-md-10" style="padding-left: 5px">
                            {!! Form::label('lbPaciente', 'Nome do Paciente') !!}
                            {!! Form::text('paciente','',array('class' => 'form-control', 'id' =>'paciente', 'placeholder' => 'Nome do Paciente' )) !!}                                
                        </div>
                        <div class="col-md-2" style="padding-left: 5px">
                            {!! Form::label('lbButton', '&nbsp;') !!}
                            <button class="btn btn-primary" id="btnLocalizarPaciente"> Localizar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding-top: 0px;padding-left: 0px;padding-right: 0px;">
                <div class="row-fluid" id="dvTableSeach"></div>
            </div>
            <div id="msgModal" class="modal-footer" style="padding-top:2px;padding-botton:2px;"></div>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script type="text/javascript">
        //Init
        $(document).ready(function (){
            $("#modalSeachPacienteByMedico").on('shown.bs.modal', function(event){
                $('#paciente').val('');
                $(event.currentTarget).find('input#paciente').first().focus();
            });
        });

        //controle de atalhos do teclado
        $(this).keypress(function(event){
            VMasker($('#nascimento')).maskPattern('99/99/9999');
            
            //Abre modal de busca de atendimento
            if( (event.which === 90 || event.which === 122) && event.shiftKey ){
                $("#modalSeachPacienteByMedico").modal({keyboard: true});
                //Limpa o grid de busca
                $("#dvTableSeach").html('');   
            }
        });
        
        $('#btnLocalizarPaciente').click(function(event){
            $('#msgModal').html('');

            if( $('#paciente').val() != '' || $('#nascimento').val() != '' ){

                $('#dvTableSeach').html('{!!config("system.messages.loadingExame")!!}<br>&nbsp;<br>&nbsp;<br>');

                var postData = [
                    {name:'paciente', 'value' : $('#paciente').val()},{name:'nascimento', 'value' : $('#nascimento').val()}
                ];
                
                var async = new AsyncClass();
                var dataResult = async.run('{{url("/")}}/medico/localizapaciente',postData,'POST');
                
                dataResult.then(function(result){
                    var table = '<table class="table">'+
                    '<thead>'+
                        '<tr>'+
                            '<th>Paciente</th>'+
                            '<th>Data Nascimento</th>'+
                            '<th>Sexo</th>'+
                            '<th>#</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>';

                        $.each( result.data, function( index ){
                            var pacientes = result.data[index];
                            table += '<tr>'+
                                    '<td>'+pacientes.nome+'</td>'+
                                    '<td>'+pacientes.data_nas+'</td>'+
                                    '<td>'+pacientes.sexo+'</td>'+
                                    '<td><a class="btn btn-xs btn-success" href="{{url()}}/medico/paciente/'+pacientes.key+'"><i class="fa fa-search"</a></td>'+
                                '</tr>';
                        });

                    table += '</tbody>';

                    if(result.data.length == 0){
                        table = '<blockquote><h4 class="center-align text-danger"> Nenhum Paciente foi localizado. </h4></blockquote>';
                    }

                    $("#dvTableSeach").html(table);

                });
            }
        });
    </script>
@stop
