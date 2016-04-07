<div class="modal fade" id="modalSeachAtendimento" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Localizar Atendimento</h2>
            </div>
            <div class="modal-body">
            	            	
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script src="{{ asset('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script type="text/javascript">
        //controle de atalhos do teclado
        $(this).keypress(function(event){
            //Abre modal de busca de atendimento
            if( (event.which === 90 || event.which === 122) && event.shiftKey ){
				$("#modalSeachAtendimento").modal({keyboard: true});
            }
        });
    </script>
@stop    