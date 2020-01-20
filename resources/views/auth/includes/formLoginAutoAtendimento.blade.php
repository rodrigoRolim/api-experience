<div >
    <div class="container-webcam">
        <div class="scan-animated"></div>
        <div class="centralizar">
            @if (count($errors) == 1)
                <div class="alert alert-danger alert-dismissable">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
        <div id="outdiv"></div>
        <div class="" id="result"></div>                    
        
        <canvas id="qr-canvas" style="display: none"></canvas>
    </div>
            
    {!! Form::open(array('url'=>'/auth/autoatendimento','id'=> 'formAutoAtendimento', 'role'=> 'form')) !!}
        {!! Form::hidden('id','', array('id'=>'id')) !!}
    {!! Form::close() !!}
</div>
@section('script')
<script src="{{ asset('/assets/js/experience/qrcode/llqrcode.js') }}"></script>
<script src="{{ asset('/assets/js/experience/qrcode/read.js') }}"></script>
    @parent
@stop