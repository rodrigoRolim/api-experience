<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="sidebar-collapse" style="overflow: hidden; width: auto; height: 100%;">
        <ul class="nav metismenu" id="side-menu">
         
            
            @foreach($atendimentos as $key => $atendimento)
                <li class="{{ !$key ? 'active'  : '' }}">
                    <a href="#" class="btnAtendimento" data-posto="{{$atendimento->posto}}" data-atendimento="{{$atendimento->atendimento}}">
                        <b class="dataMini">
                            <p class="text-center" style="margin:0px;line-height: 14px">{{ date('d/m',strtotime($atendimento->data_atd))}}<br>
                            {{ date('Y',strtotime($atendimento->data_atd))}}</p>
                        </b>
                        <span class="nav-label"><strong>{{ date('d/m/y',strtotime($atendimento->data_atd))}}</strong><br>
                        {{str_limit($atendimento->mnemonicos,56)}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 381.225px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.9; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
</nav>

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            sizeBoxExames();

            $('.metismenu li i').attr('style','display:none');

            resizeDisplay();

            $('.navbar-minimalize').click(function () {
                $("body").toggleClass("mini-navbar");
            });

            $(window).bind("resize", function () {
              resizeDisplay();
            });

            function sizeBoxExames(){
                $('#side-menu').slimScroll({
                 height: '76vh',
                 railOpacity: 0.4,
                 wheelStep: 10
                });
            }

            function resizeDisplay(){
               if ($(this).width() < 769) {
                    $('body').addClass('body-small');
                    $('body').addClass('mini-navbar');
                    $('.metismenu li b').attr('style','display:1');
                } else {
                    $('body').removeClass('body-small');
                    $('body').removeClass('mini-navbar');
                    $('.metismenu li b').attr('style','display:none');
                }

                sizeBoxExames();
            }
        });
    </script>
@stop