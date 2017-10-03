{!! Form::open(array('url'=>'/auth/login','id'=> 'formPosto', 'role'=> 'form')) !!}
    <input name="tipoAcesso" type="hidden" id="tipoAcesso" value="POS">
    <div class="form-group">
        <label>Usuário</label> 
         <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-user"></i></span>
			{!! Form::text('usuario', Input::old('usuario'), array('placeholder' => 'usuario', 'autocomplete'=>'off' , 'class'=>'form-control','id'=>'usuario','placeholder'=>'Usuário')) !!}
	   </div>                
    </div>
    <div class="form-group">
        <label>Senha</label>
       <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required="" autocomplete="off">
	   </div>            
    </div>
    <div class="form-group">
        <label>Posto</label> 
         <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
            {!! Form::select('posto', $postos, '', array('class' => 'form-control m-b', 'id'=>'posto')) !!}
       </div>                
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

@section('script')
<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    @parent
@stop