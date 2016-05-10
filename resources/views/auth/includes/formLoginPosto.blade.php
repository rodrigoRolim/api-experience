{!! Form::open(array('url'=>'/auth/login','id'=> 'formPosto', 'role'=> 'form')) !!}
    <input name="tipoAcesso" type="hidden" id="tipoAcesso" value="POS">
    <div class="form-group">
        <label>Posto</label> 
         <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
			{!! Form::text('posto', Input::old('posto'), array('placeholder' => 'Posto', 'autocomplete'=>'off' , 'class'=>'form-control','id'=>'posto','placeholder'=>'Posto')) !!}
	   </div>                
    </div>
    <div class="form-group">
        <label>Senha</label>
       <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Senha" required="" autocomplete="off">
	   </div>            
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

@section('script')
<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script type="text/javascript">
        VMasker(document.getElementById("posto")).maskPattern("{{config('system.postoMask')}}");    
    </script>

    @parent
@stop