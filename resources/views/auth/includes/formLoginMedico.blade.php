{!! Form::open(array('url'=>'/auth/login','id'=> 'formMedico', 'role'=> 'form')) !!}
    <input name="tipoAcesso" type="hidden" id="tipoAcesso" value="MED">
    <div class="form-group">
        <label>Informações CR</label>
        <div class="row">
            <div class="col-md-6">
                <select class="form-control m-b" name="tipoCr">
                    <option value="">Selecione</option> 
                    <option vauue="CRM" selected="selected">CRM</option>
                    <option value="COREN">COREN</option>
                    <option value="CRBiO">CRBIO</option>
                    <option value="CRBM">CRBM</option>
                    <option value="CREFITO">CREFITO</option>
                    <option value="CRF">CRF</option>
                    <option value="CRFA">CRFA</option>
                    <option value="CRMV">CRMV</option>
                    <option value="CRN">CRN</option>
                    <option value="CRO">CRO</option>
                    <option value="CRP">CRP</option>        
                </select>
            </div>    
            <div class="col-md-6">
                <select class="form-control m-b" name="uf">
                    <option value="AC">AC</option> 
                    <option value="AL">AL</option> 
                    <option value="AM">AM</option> 
                    <option value="AP">AP</option> 
                    <option value="BA">BA</option> 
                    <option value="CE">CE</option> 
                    <option value="DF">DF</option> 
                    <option value="ES">ES</option> 
                    <option value="GO">GO</option> 
                    <option value="MA" selected="selected">MA</option> 
                    <option value="MT">MT</option> 
                    <option value="MS">MS</option> 
                    <option value="MG">MG</option> 
                    <option value="PA">PA</option> 
                    <option value="PB">PB</option> 
                    <option value="PR">PR</option> 
                    <option value="PE">PE</option> 
                    <option value="PI">PI</option> 
                    <option value="RJ">RJ</option> 
                    <option value="RN">RN</option> 
                    <option value="RO">RO</option> 
                    <option value="RS">RS</option> 
                    <option value="RR">RR</option> 
                    <option value="SC">SC</option> 
                    <option value="SE">SE</option> 
                    <option value="SP">SP</option> 
                    <option value="TO">TO</option> 
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Número do CR</label>
         <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-stethoscope"></i></span>
            <input type="number" class="form-control" id="cr" name="cr" placeholder="CR" required="">
        </div>       
    </div>
    <div class="form-group">
        <label>Senha</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control" id="password" placeholder="Senha" name="password" required="">
        </div>
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}

