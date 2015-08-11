{!! Form::open(array('url'=>'/login','id'=> 'formPosto', 'role'=> 'form')) !!}
    <input name="tipoAcesso" type="hidden" id="tipoAcesso" value="POS">
    <div class="form-group">
        <label>Posto</label> 
         <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
			  <input type="text" data-mask="{{config('system.postoMask')}}" class="form-control" id="posto" placeholder="Posto" required="">
	   </div>       
    </div>
    <div class="form-group">
        <label>Senha</label>
       <div class="input-group">
	        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
			<input type="password" class="form-control" placeholder="Senha" required="">
	   </div>
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}