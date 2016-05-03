      <!-- Sidebars -->
      <div class="snap-drawers">

        <!-- Left Sidebar -->
        <div class="snap-drawer snap-drawer-left">
          <div class="drawer-inner">
            <ul>
            	<li><a href='/paciente'><i class="mdi mdi-needle"></i> <span>Atendimentos</span></a></li>
              @if(Auth::user()['tipoLoginPaciente'] == 'CPF')
                <li><a href='/paciente/perfil'><i class="mdi mdi-account"></i> <span>Alterar Senha</span></a></li>
              @endif
              <li><a href='/auth/logout'><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

