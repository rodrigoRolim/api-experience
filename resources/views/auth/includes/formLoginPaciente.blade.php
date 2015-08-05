{!! Form::open(array('url'=>'/auth/login','id'=> 'formPaciente', 'role'=> 'form', 'novalidate')) !!}
	<label>Acessar como?</label>
	<input name="tipoAcesso" type="hidden" id="tipoAcesso" value="PAC">
	<input name="tipoLoginPaciente" type="hidden" id="tipoLoginPaciente">
	<div class="i-checks">
		<label><input type="radio" value="ID" name="tipoLoginPaciente" checked> ID </label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" value="CPF"  name="tipoLoginPaciente"> CPF </label>
	</div>	
	<div id="itemAtendimento">
	    <div class="form-group">
	        <label>Atendimento</label>
	          <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            	<input type="text" data-mask="{{config('system.atendimentoMask')}}" id="atendimento" class="form-control" placeholder="Atendimento" required="">          	
            </div>
	    </div>
	</div>	
	<div id="itemCliente">
		<div class="form-group">
	        <label>CPF</label>
	        <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

            	<input type="text" data-mask="999.999.999-99" id="cpf" class="form-control" placeholder="CPF" required="">
          </div>	      
	    </div>
	    <div class="form-group">
	        <label>Data de Nascimento</label>
	        <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            	<input type="text" id="nascimento" data-mask="99/99/9999" class="form-control" placeholder="Data de Nascimento" required="">    
            </div>
	    </div>
		</div>
	    <div class="form-group">
	        <label>Senha</label>
	        <div class="input-group">
	            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" name="password" class="form-control" placeholder="Senha" required="">
	        </div>
	    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

@section('script')
	<script type="text/javascript">

		$('#itemCliente').hide();

	     $(document).ready(function(){
	     	$('#atendimento').focus();
	     	
	     	$('.i-checks').iCheck({
	            checkboxClass: 'icheckbox_square-grey',
	            radioClass: 'iradio_square-grey',
	        });

			$('#nascimento').datepicker({
	            startView: 1,
	            todayBtn: "linked",
	            keyboardNavigation: true,
	            forceParse: false,
	            autoclose: true,
	            format: "dd/mm/yyyy"
	        });

	        $('.i-checks').on('ifChecked', function(event){
	        	var tipoLogin = event.target.defaultValue;

				if( tipoLogin == 'CPF'){
					$('#itemCliente').show();
					$('#itemAtendimento').hide();
					$('#tipoLoginPaciente').val('CPF');	
					document.getElementById("cpf").focus();
				}else{
					$('#itemCliente').hide();
					$('#itemAtendimento').show();
					$('#tipoLoginPaciente').val('ID');
					document.getElementById("atendimento").focus();
				}

	        });
	     });
	</script>

	@parent
@stop