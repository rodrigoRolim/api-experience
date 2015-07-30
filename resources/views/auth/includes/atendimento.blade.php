<h1>LOGIN PACIENTE</h1>

<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="tipoAcesso" value="PACIENTE">

    {!! Form::radio('tipo', 'ID',true) !!}ID {!! Form::radio('tipo', 'CPF') !!}CPF <br>

    <h4>Por ID</h4>
    <div class="form-group @if ($errors->has('posto')) has-error @endif">
        {!! Form::text('posto', Input::old('posto'), array('placeholder' => 'Posto', 'class'=>'form-control')) !!}
        @if ($errors->has('posto')) <p class="help-block">{{ $errors->first('posto') }}</p> @endif
    </div>

    <div class="form-group @if ($errors->has('atendimento')) has-error @endif">
        {!! Form::text('atendimento', Input::old('atendimento'), array('placeholder' => 'Atendimento', 'class'=>'form-control')) !!}
        @if ($errors->has('atendimento')) <p class="help-block">{{ $errors->first('atendimento') }}</p> @endif
    </div>

    <div class="form-group @if ($errors->has('senhaId')) has-error @endif">
        {!! Form::password('senhaId', array('placeholder' => 'Senha', 'class'=>'form-control')) !!}
        @if ($errors->has('senhaId')) <p class="help-block">{{ $errors->first('senhaId') }}</p> @endif
    </div>

    <div class="form-group" style="margin-left:0px">
        <div class="checkbox i-checks"><label> <input name="remember" type="checkbox"><i></i> Mantenha-me conectado </label></div>
    </div>

    <h4>Por CPF</h4>
    <div class="form-group @if ($errors->has('cpf')) has-error @endif">
        {!! Form::text('cpf', Input::old('cpf'), array('placeholder' => 'CPF', 'class'=>'form-control')) !!}
        @if ($errors->has('cpf')) <p class="help-block">{{ $errors->first('cpf') }}</p> @endif
    </div>

    <div class="form-group @if ($errors->has('nascimento')) has-error @endif">
        {!! Form::text('nascimento', Input::old('nascimento'), array('placeholder' => 'Nascimento', 'class'=>'form-control')) !!}
        @if ($errors->has('nascimento')) <p class="help-block">{{ $errors->first('nascimento') }}</p> @endif
    </div>

    <div class="form-group @if ($errors->has('senhaCpf')) has-error @endif">
        {!! Form::password('senhaCpf', array('placeholder' => 'Senha', 'class'=>'form-control')) !!}
        @if ($errors->has('senhaCpf')) <p class="help-block">{{ $errors->first('senhaCpf') }}</p> @endif
    </div>

    <div class="form-group" style="margin-left:0px">
        <div class="checkbox i-checks"><label> <input name="remember" type="checkbox"><i></i> Mantenha-me conectado </label></div>
    </div>

    {!! Form::submit('Fazer login', array('class' => 'btn btn-success block full-width m-b')) !!}
</form>