      <!-- Sidebars -->
      <div class="snap-drawers">

        <!-- Left Sidebar -->
        <div class="snap-drawer snap-drawer-left">
          <div class="drawer-inner">
            <ul>
              <li><a><i class="mdi mdi-account"></i> <span>Perfil</span></a></li>
            </ul>
            <ul class="exit">
              <li><a  href="{{url('/')}}/auth/logout"><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
              </li>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="snap-drawer snap-drawer-right">
          <div class="drawer-inner filtros">
            <div class="row">
              <div class="col l5 s5 m5 dataInicial">
                  <input type="date" class="datepicker">
              </div>
              <div class="col l1 s1 m1 midData"> Até</div> 
              <div class="col l5 s5 m5 dataFinal">
                  <input type="date" class="datepicker">
              </div>
            </div>  
            <div class="row">
                <div class="input-field col s12">
                  <select id="convenio">
                    <option value="" disabled selected>Convenios</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                  </select>
                </div>
                  <div class="input-field col s12">
                  <select id="posto">
                    <option value="" disabled selected>Posto Realizante</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                  </select>
                </div>
                  <div class="input-field col s12">
                  <select id="situacao">
                    <option value="" disabled selected>Situação</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                  </select>
                </div>
            </div>
            <div class="row">
                <button id="btnFiltrar" class="btn waves-effect red lighten-1" type="submit" name="action">Filtrar</button>
            </div>          
          </div>
        </div> <!-- End of Right Sidebar -->
     </div>  <!-- End of Sidebars