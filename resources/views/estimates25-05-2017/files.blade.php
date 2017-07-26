@extends('layouts.app')
@section('content')

<h1>Elenco files del preventivo: <strong>{{$oggetto}}</strong></h1>

@if(!empty(Session::get('msg')))
    <script>    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';    document.write(msg);    
</script>
@endif
<button class="btn btn-info" onclick="window.close();" title="Torna al preventivo"><i class="fa fa-arrow-left"></i></button><br>
@foreach($files as $file)
	<div class="col-md-4">        
		<a target="new" class="btn btn-primary" href="{{url('/storage/app/images') . '/' . $file->nome}}">{{$file->nome}}</a>
		<a onclick="return confirm('Sei sicuro di voler eliminare questo file?');" href="{{url('/progetti/files/elimina') . '/' . $file->id}}" class="btn btn-warning">Elimina file</a>
	</div>
@endforeach
@endsection