      <!-- Sidebars -->
      <div class="snap-drawers">

        <!-- Left Sidebar -->
        <div class="snap-drawer snap-drawer-left">
          <div class="drawer-inner">
            <ul>
              <li><a href="index.html"><i class="mdi mdi-home"></i> <span>Pagina Inicial</span></a></li>
                <li class="have-child">
                <ul class="collapsible" data-collapsible="accordion">
                  <li>
                    <div class="collapsible-header">
                      <i class="mdi mdi-needle"></i> Exames <i class="mdi mdi-menu-down right"></i>
                    </div>
                    <div class="collapsible-body">
                      <ul class="collapsible" data-collapsible="accordion">
                      @foreach($atendimentos as $key => $atendimento)
                        <li id="btnAtendimento" data-posto="{{$atendimento->posto}}" data-atendimento="{{$atendimento->atendimento}}" data-mnemonicos="{{$atendimento->mnemonicos}}">
                          <div class="collapsible-header">
                            	<i class="mdi mdi-beaker-empty-outline"></i>{{$atendimento->posto}} | {{$atendimento->atendimento}}
                          </div>
                        </li>
                      @endforeach
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>
              <li><a href="profile.html"><i class="mdi mdi-account"></i> <span>Perfil</span></a></li>
            </ul>
            <ul class="exit">
              <li><a href="login.html"><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
              </li>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

        <!-- Right Sidebar -->
        <!-- <div class="snap-drawer snap-drawer-right">
          <div class="drawer-inner">
            <ul>
              <li><a href="timeline.html"><i class="mdi mdi-timelapse"></i> <span>Timeline</span></a></li>
              <li><a href="messages.html"><i class="mdi mdi-bell"></i> <span>Messages <span class="badge white z-depth-1">2</span></span></a></li>
              <li><a href="todo.html"><i class="mdi mdi-checkbox-marked-outline"></i> <span>ToDo</span></a></li>
              <li><a href="login.html"><i class="mdi mdi-account-circle"></i> <span>Login</span></a></li>
              <li><a href="signup.html"><i class="mdi mdi-account-plus"></i> <span>Account Creation</span></a></li>
            </ul>
          </div>
        </div> <!-- End of Right Sidebar -->
     </div>  <!-- End of Sidebars -->