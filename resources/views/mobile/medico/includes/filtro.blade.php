<div>
  <div class="filtros">
    <div id="formMedico">
      <br><label class="center-align">&nbsp;&nbsp;Visualizar pacientes atendidos entre:</label>
      <div class="row">
          <div class="input-field col s12">
              <label>Periodos</label><br><br>
              <select id="comboPeriodos">
                <option value="" disabled selected>Selecione</option>
                <option id="ontem" name="ontem"> Ultimos 3 dias </option>
                <option id="ultimos10" name="ultimos10"> Ultimos 5 dias </option>
                <option id="ultimoMes" name="ultimoMes"> Ultimos 15 dias </option>
              </select>
          </div>
      </div>
      <div class="center-align"> Ou </div><br>
      <label>&nbsp;&nbsp; Atendimentos por datas entre:</label>
      <div id="filtroDatas" class="row">
        <div class="col l5 s5 m5 dataInicial">
            <input type="date" id="dataInicio" name="dataInicio" class="datepicker">
        </div>
        <div class="col l2 s2 m2 midData center-align"> até</div> 
        <div class="col l5 s5 m5 dataFinal">
            <input type="date" id="dataFim" name="dataFim" class="datepicker">
        </div>
      </div>  
      <div class="center-align"> Ou </div><br>
      
      <div class="row">
        <div class="col l12 s12 m12">
          <input type="text" id="paciente" name="paciente" class="datepicker" placeholder="Digite o nome do paciente">
        </div>
      </div>
      
      <div class="row">
          <button id="btnFiltrar" class="btn waves-effect red lighten-1">Filtrar</button>
      </div>
    </div>
  </div>
</div>