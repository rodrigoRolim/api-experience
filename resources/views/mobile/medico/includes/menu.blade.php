      <!-- Sidebars -->
      <div class="snap-drawers">

        <!-- Left Sidebar -->
        <div class="snap-drawer snap-drawer-left">
          <div class="drawer-inner">
            <ul>
              <li><a><i class="mdi mdi-account"></i> <span>Alterar Senha</span></a></li>
              <li><a  href="{{url('/')}}/auth/logout"><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="snap-drawer snap-drawer-right">
          <div class="drawer-inner filtros">
            <div id="formMedico">
              <label>&nbsp;&nbsp;Visualizar pacientes atendidos entre:</label>
              <div class="row">
                  <div class="input-field col s12">
                      <label>Periodos</label><br><br>
                      <select id="comboPeriodos">
                        <option value="" disabled selected>Selecione</option>
                        <option id="ontem" name="ontem"> Ontem </option>
                        <option id="ultimos10" name="ultimos10"> Ultimos 10 dias </option>
                        <option id="ultimoMes" name="ultimoMes"> Ultimo Mês </option>
                      </select>
                  </div>
              </div>
              <label class="center-align"> Ou </label><br>
              <label>&nbsp;&nbsp; Atendimentos por datas entre:</label>
              <div id="filtroDatas" class="row">
                <div class="col l5 s5 m5 dataInicial">
                    <input type="date" id="dataInicio" name="dataInicio" class="datepicker">
                </div>
                <div class="col l1 s1 m1 midData"> até</div> 
                <div class="col l5 s5 m5 dataFinal">
                    <input type="date" id="dataFim" name="dataFim" class="datepicker">
                </div>
              </div>  
              <div class="row">
                  <button id="btnFiltrar" class="btn waves-effect red lighten-1">Filtrar</button>
              </div>
            </div>          
          </div>
        </div> <!-- End of Right Sidebar -->
     </div>  <!-- End of Sidebars


