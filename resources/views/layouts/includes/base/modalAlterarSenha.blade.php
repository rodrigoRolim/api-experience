<div class="modal fade" id="modalAlterarSenha" role="dialog">
    <div class="modal-dialog">                
        <div class="modal-conteudo">
            <div class="modal-topo">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-titulo">Alterar senha de acesso</h2>
            </div>
            {!! Form::open(array('id' => 'formSenha')) !!}
                <div class="modal-corpo">
                    <div id="msg"></div>
                    <div class="col-md-12">
                        {!! Form::label('SenhaAtual', 'Senha Atual') !!}
                        {!! Form::password('senhaAtual',array('class' => 'form-control', 'id' =>'senhaAtual', 'placeholder' => 'Senha Atual' )) !!}                                 
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('novaSenha', 'Nova Senha') !!}
                        {!! Form::password('novaSenha',array('class' => 'form-control', 'id' =>'novaSenha', 'placeholder' => 'Nova Senha' )) !!}                                
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('confirmarSenha', 'Confirmar Nova Senha') !!}
                        {!! Form::password('confirmarSenha',array('class' => 'form-control', 'id' =>'confirmarSenha', 'placeholder' => 'Confirmar Nova Senha' )) !!}             
                    </div>
                </div>
                <div class="modal-rodape">
                    <a class="btn btn-success" id="btnSalvarPerfil">Salvar</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ asset('/assets/js/jquery-2.1.1.js') }}"></script>

    <script src="{{ asset('/assets/js/plugins/validate/jquery.validate.min.js') }}"></script>

    <script type="text/javascript">

        $('.modal-rodape').css('border-top', '0px');  
        var form = $('#formSenha');
                
            form.validate({
                rules: {
                    senhaAtual: {
                        required: true
                    },
                    novaSenha: {
                        required: true,
                        minlength: 6,
                        maxlength:15
                    },
                    confirmarSenha: {
                        required: true,
                        equalTo: "#novaSenha",
                        minlength: 6,
                        maxlength:15
                    }
                },
            });


        $('.btnShowModal').click(function(e){
                $('#modalAlterarSenha').modal('show');
                $('#msg').html(' ');
                $('#senhaAtual').val('');
                $('#novaSenha').val('');
                $('#confirmarSenha').val('');               
            });

             $('#btnSalvarPerfil').click(function(e){                                          

                if(form.valid()){
                    //serializa dos dados do formulario
                    var postData = form.serializeArray();

                    $.ajax({
                        url : '{{url()}}/medico/alterarsenha',
                        type: 'POST',
                        data : postData,
                        success:function(data, textStatus, jqXHR) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);
                            var style = (jqXHR['status'] == 200 ? 'success':'danger');

                            $('#msg').html('<div class="alert alert-'+style+' alert-dismissable animated fadeIn">'+msg.message+'</div>');    
                        },
                        error: function(jqXHR, textStatus, errorThrown) 
                        {
                            var msg = jqXHR.responseText;
                            msg = JSON.parse(msg);

                            $('#msg').html('<div class="alert alert-danger alert-dismissable animated fadeIn">'+msg.message+'</div>');
                        }
                    });
                }else{
                    $('#msg').html('<div class="alert alert-danger alert-dismissable animated fadeIn">Preencha os dados corretamente</div>');
                }

                e.preventDefault();                
            });
    </script>
@show