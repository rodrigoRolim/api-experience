{!! Form::open(array('url'=>'/auth/login','id'=> 'formPaciente', 'role'=> 'form', 'novalidate', 'method' => 'post')) !!}
	<div id="radioAcessoPac">
		<input name="tipoAcesso" type="hidden" id="tipoAcesso" value="PAC">
		<input name="tipoLoginPaciente" type="hidden" id="tipoLoginPaciente" value="ID">
	</div>	
	<div id="itemAtendimento">
	    <div class="form-group @if ($errors->has('atendimento')) has-error @endif">
	        <label>Atendimento</label>
	          <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            	{!! Form::text('atendimento', Input::old('atendimento'), array('placeholder' => 'Atendimento', 'autocomplete'=>'off', 'class'=>'form-control','id'=>'atendimento')) !!}
			  </div>
			  @if ($errors->has('atendimento')) <p class="help-block">{{ $errors->first('atendimento') }}</p> @endif
		</div>
		<div class="form-group @if ($errors->has('password')) has-error @endif">
	        <label>Senha</label>
	        <div class="input-group">
	            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" id="senha" class="form-control" placeholder="Senha" required="" name="password" autocomplete="off">
	        </div>
			@if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
	    </div>
	</div>
	
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

@section('script')
<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
	<script type="text/javascript">
	    $(document).ready(function(){
	        VMasker($('#atendimento')).maskPattern("{{config('system.atendimentoMask')}}");
	    	$('#atendimento').focus();
	    });
	</script>
	@parent
@stop