<<<<<<< HEAD
@if (count($errors) == 1)
    <div class="alert alert-danger alert-dismissable">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

{!! Form::open(array('url'=>'/auth/autoatendimento','id'=> 'formAutoAtendimento', 'role'=> 'form')) !!}
	{!! Form::hidden('id','eyJwb3N0byI6ICIwMCIsImF0ZW5kaW1lbnRvIjogIjAwMTkyNyIsInNlbmhhIiA6ICJMMVVLSEwifQ==', array('id'=>'id')) !!}
    <button type="submit" class="btn btn-primary block full-width m-b">Acessar</button>
{!! Form::close() !!}
=======
>>>>>>> efe50a9c27e5a33dd7058d042cedaaef56d7f53d
