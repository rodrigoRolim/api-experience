      <!-- Sidebars -->
      <div class="snap-drawers">

        <!-- Left Sidebar -->
        <div class="snap-drawer snap-drawer-left">
          <div class="drawer-inner">
            <ul>
                <li class="have-child">
                <ul class="collapsible" data-collapsible="accordion">
                  <li>
                    <div class="collapsible-header">
                      <i class="mdi mdi-needle"></i> Atendimentos <i class="mdi mdi-menu-down right"></i>
                    </div>
                    <div class="collapsible-body">
                      <ul class="collapsible" li="listaAtendimentos" data-collapsible="accordion">
                      @foreach($atendimentos as $key => $atendimento)
                        <li class="btnAtendimento" data-posto="{{$atendimento->posto}}" data-atendimento="{{$atendimento->atendimento}}" data-mnemonicos="{{$atendimento->mnemonicos}}" data-acesso="{{Auth::user()['tipoAcesso']}}">
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
              <li><a><i class="mdi mdi-account"></i> <span>Perfil</span></a></li>
              <li><a href='/auth/logout'><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="snap-drawer snap-drawer-right">
          <div class="drawer-inner">
            <div class="row">
              <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                  <div class="card-content white-text">
                    <span class="card-title">Card Title</span>
                    <div class="card-content">
                      <p>I am a very simple card. I am good at containing small bits of information.
                      I am convenient because I require little markup to use effectively.</p>
                    </div>
                  </div>
                  <div class="card-action">
                    <a href="#">This is a link</a>
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div> <!-- End of Right Sidebar -->
     </div>  <!-- End of Sidebars