<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="sidebar-collapse" style="overflow: hidden; width: auto; height: 100%;">
        <ul class="nav metismenu" id="side-menu">
         
            
            @foreach($atendimentos as $key => $atendimento)
                <li class="{{ !$key ? 'active' : '' }}">
                    <a href="#" class="btnAtendimento" data-posto="{{$atendimento->posto}}" data-atendimento="{{$atendimento->atendimento}}">
                        <b class="dataMini">
                            <p class="text-center" style="margin:0px;line-height: 14px">{{ date('d/m',strtotime($atendimento->data_atd))}}<br>
                            {{ date('Y',strtotime($atendimento->data_atd))}}</p>
                        </b>
                        <span class="nav-label mnemonicos"><strong>{{ date('d/m/y',strtotime($atendimento->data_atd))}}</strong><br>
                        {{str_limit($atendimento->mnemonicos,56)}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
</nav>

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('li:first-child').addClass('active');
            sizeBoxExames();

            $('.metismenu li i').attr('style','display:none');

            resizeDisplay();

            $('.navbar-minimalize').click(function () {
                $("body").toggleClass("mini-navbar");
            });

            $(window).bind("resize", function () {
              resizeDisplay();
            });

            
            $('li').click(function(event) {
               $('li').not(this).removeClass('active clicked');    /// Alternancia de fundos ao clicar/selecionar um atendimento da lista. (linhas 63-66).           
               $('li').not(this).addClass('notClicked');
               $(this).toggleClass('active clicked');
               $(this).toggleClass('notClicked');  
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