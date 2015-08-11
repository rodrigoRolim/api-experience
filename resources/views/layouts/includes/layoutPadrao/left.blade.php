<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="sidebar-collapse" style="overflow: hidden; width: auto; height: 100%;">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                FILTRO	                        
            </li>
            
            @foreach($atendimentos as $key => $atendimento)
                <li class="{{ !$key ? 'active'  : '' }}">
                    <a href="#">
                        <b><span class="nav-label">{{ date('d/m/y',strtotime($atendimento->data_atd))}}<br></b>
                        <span class="nav-label">{{$atendimento->mnemonicos}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 381.225px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.9; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
</nav>
