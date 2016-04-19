<div class="modal fade" id="modalSeachAtendimento" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Localizar Atendimento</h2>
            </div>
            <div class="modal-body">
                <div class="content"> 
                    <div class="exemploBusca"> Ex: {{config('system.atendimentoMask')}}</div>
                    <div class="row-fluid">
                        <div style="padding-left:10px;padding-right:10px">
                            {!! Form::text('atendimento','', array('placeholder' => 'Digite o número do atendimento e pressione ENTER','class'=>'form-control input-lg','id'=>'atendimento')) !!}
                        </div>
                    </div>
                </div>
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
            $("#modalSeachAtendimento").on('shown.bs.modal', function(event){
                $('#atendimento').val('');
                $(event.currentTarget).find('input#atendimento').first().focus();
            });
        });

        //controle de atalhos do teclado
        $(this).keypress(function(event){
            VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
            //Abre modal de busca de atendimento
            if( (event.which === 90 || event.which === 122) && event.shiftKey ){
                $("#modalSeachAtendimento").modal({keyboard: true});
            }
        });
        // controle de atalho no input atendimento
        $('#atendimento').keypress(function(event){
            $('#msgModal').html('');
            
            //ENTER no input atendimento
            if(event.which === 13){

                if( $('#atendimento').val() != '' ){
                    var postData = [{name:'atendimento','value':$('#atendimento').val()}];
                    //Instancia a class Async
                    var async = new AsyncClass();
                    var dataResult = async.run('{{url("/")}}/posto/localizaatendimento',postData,'POST');

                    dataResult.then(function(result){
                        var atendimento = $.parseJSON(result.data);

                        if(atendimento.length == '1'){
                            var key = atendimento[0].key;
                            $(window.document.location).attr('href',"{{url('/')}}/posto/paciente/"+key+"/"+atendimento[0].posto+"/"+atendimento[0].atendimento);
                        }else{
                            $('#msgModal').html('<h4 class="text-danger" style="padding:0xp;margin:0px">Atendimento não localizado</h4>');
                        }
                    });
                }
            }
        });
    </script>
@stop