{!! Form::open(array('url'=>'/auth/login','id'=> 'formParceiro', 'role'=> 'form')) !!}
    <input name="tipoAcesso" type="hidden" id="tipoAcesso" value="POS">
    <div class="form-group">
        <label>Código Parceiro</label> 
         <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
			{!! Form::text('codparceiro', Input::old('codparceiro'), array('placeholder' => 'codparceiro', 'class'=>'form-control','id'=>'codparceiro','placeholder'=>'Código do Parceiro')) !!}
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
<script src="{{ asset('/assets/js/plugins/vanillamasker/vanilla-masker.min.js') }}"></script>
    <script type="text/javascript">
        VMasker(document.getElementById("codparceiro")).maskPattern("{{config('system.codparceiroMask')}}");    
    </script>

    @parent
@stop