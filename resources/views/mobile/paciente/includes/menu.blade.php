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
                        <li class="btnAtendimento"  
                        data-convenio="{{$atendimento->nome_convenio}}" 
                        data-solicitante="{{$atendimento->nome_solicitante}}" 
                        data-dtatendimento="{{ date('d/m/20y',strtotime($atendimento->data_atd))}}" 
                        data-posto="{{$atendimento->posto}}"
                        data-atendimento="{{$atendimento->atendimento}}" 
                        data-mnemonicos="{{$atendimento->mnemonicos}}" 
                        data-acesso="{{Auth::user()['tipoAcesso']}}" 
                        data-saldo="{{$atendimento->saldo_devedor}}">
                          <div class="collapsible-header">
                            	<span id="dataAtendimento">{{ date('d/m/20y',strtotime($atendimento->data_atd))}}</span> - {{$atendimento->posto}} | {{$atendimento->atendimento}}<br>
                              <span class='truncate mnemonicoAtd'>{{$atendimento->mnemonicos}}</span>
                          </div>
                        </li>
                      @endforeach
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>
              @if(Auth::user()['tipoAcesso'] == 'PAC' && Auth::user()['tipoLoginPaciente'] == 'CPF')
                <li><a href='/paciente/perfil'><i class="mdi mdi-account"></i> <span>Alterar Senha</span></a></li>
              @endif
              @if(Auth::user()['tipoAcesso'] == 'MED')
              <li><a href="{{url('/')}}/medico/"><i style="line-height: 1rem;" class="mdi-heart-outline"></i> <span>Pacientes</span></a></li>
              @endif
              <li id="gerarPdfMenu"><span style="font-size:22px"><i class="mdi-comment-text"></i> <span> &nbsp;&nbsp;&nbsp;Resultados em PDF</span></span></li>
              <li><a href='/auth/logout'><i class="mdi mdi-exit-to-app"></i> <span>Logout</span></a>
            </ul>
          </div>
        </div> <!-- End of Left Sidebar -->

        <!-- Right Sidebar -->
<!--         <div class="snap-drawer snap-drawer-right">
          <div class="drawer-inner">
            <div class="row">
              <div class="col s12 m6">
                <div class="card blue-text text-darken-2">
                    <div class="card-title center-align">  </div>
                  <div class="card-content">
                    <div class="card-content">
                  
                    </div>
                  </div>
                  <div class="card-footer">

                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div> <!-- End of Right Sidebar --> 
     </div>  <!-- End of Sidebars