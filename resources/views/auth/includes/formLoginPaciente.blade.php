{!! Form::open(array('url'=>'/auth/login','id'=> 'formPaciente', 'role'=> 'form', 'novalidate')) !!}

	<div id="radioAcessoPac">
		<label>Acessar como?</label>
		<input name="tipoAcesso" type="hidden" id="tipoAcesso" value="PAC">
		<input name="tipoLoginPaciente" type="hidden" id="tipoLoginPaciente">
		<div class="i-checks">
			<label><input id="rdId" type="radio" value="ID" name="tipoLoginPaciente" checked> ID </label>&nbsp;&nbsp;&nbsp;
			<label><input id="rfCpf" type="radio" value="CPF"  name="tipoLoginPaciente"> CPF </label>
		</div>
	</div>	
	<div id="itemAtendimento">
	    <div class="form-group @if ($errors->has('atendimento')) has-error @endif">
	        <label>Atendimento</label>
	          <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            	{!! Form::text('atendimento', Input::old('atendimento'), array('placeholder' => 'Atendimento', 'class'=>'form-control','id'=>'atendimento')) !!}
			  </div>
			  @if ($errors->has('atendimento')) <p class="help-block">{{ $errors->first('atendimento') }}</p> @endif
		</div>
	</div>

	<div id="itemCliente">
		<div class="form-group @if ($errors->has('cpf')) has-error @endif">			
	        <label class="labelCpf">CPF</label>
	        <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            	{!! Form::text('cpf', Input::old('cpf'), array('placeholder' => 'CPF', 'class'=>'form-control','id'=>'cpf', 'required' => '')) !!}
          	</div>
		  	@if ($errors->has('cpf')) <p class="help-block">{{ $errors->first('cpf') }}</p> @endif
	    </div>
	    <div class="form-group @if ($errors->has('nascimento')) has-error @endif">
	        <label>Data de Nascimento</label>
	        <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            	<input type="text" id="nascimento" name="nascimento" class="form-control" placeholder="Data de Nascimento" required="">
            </div>
			@if ($errors->has('nascimento')) <p class="help-block">{{ $errors->first('nascimento') }}</p> @endif
		</div></div>
	    <div class="form-group @if ($errors->has('password')) has-error @endif">
	        <label>Senha</label>
	        <div class="input-group">
	            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" id="senha" class="form-control" placeholder="Senha" required="" name="password">
	        </div>
			@if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
	    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

@section('script')
<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
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

	        VMasker($('#nascimento')).maskPattern('99/99/9999');
	        VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
	        VMasker($('#cpf')).maskPattern('999.999.999-99');    

	        $('.i-checks').on('ifChecked', function(event){
	        	var tipoLogin = event.target.defaultValue;

				if( tipoLogin == 'CPF'){
					$('#itemCliente').show();
					$('#itemAtendimento').hide();
					$('#tipoLoginPaciente').val('CPF');	
					$('.labelCpf').append(" <span class='msgCpfAcesso'>({{config('system.messages.paciente.msgCpfAcesso')}})")
					document.getElementById("cpf").focus();
				}else{
					$('#itemCliente').hide();
					$('#itemAtendimento').show();
					$('#tipoLoginPaciente').val('ID');
					document.getElementById("atendimento").focus();
				}

	        });
	     });

        var autoAtendimento = '{{config('system.acessoAutoAtendimentoTeclado')}}';

   		if(autoAtendimento){
    		$('.loginColumns').css('max-width', '90%');
    		$('#areaTeclado').toggleClass('col-md-6 col-md-7');
    		$('#areaLogin').toggleClass('col-md-6 col-md-5');
    		$('#infoExperience').css('margin-left', '50px');  
    		$('#infoExperience').css('margin-top', '30px');  
    		$('#radioAcessoPac').hide();       			
   		}

		//Funções Teclado Numerico
   		var elementoFocado = 'atendimento'; //default preenche atendimento

   		$('#atendimento, #senha').focus(function() {
   		 	elementoFocado = document.activeElement.id;
   		});

        $('.btnSetNumero').on('click', function() {
        	document.getElementById(elementoFocado).value += this.value;
            VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
        });

        $('#upperTeclado').on('click', function() {
        	$('.btnSetNumero').toggleClass('upper lower');
        });

        $('#btnLimpar').on('click', function() {
        	apagar =  $('#atendimento').val().slice(0, -1);
            document.getElementById("atendimento").value = apagar;
            VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
        });

        $('#btnLimparTudo').on('click', function() {
            document.getElementById("atendimento").value = '';
        });
	</script>

	@parent
@stop