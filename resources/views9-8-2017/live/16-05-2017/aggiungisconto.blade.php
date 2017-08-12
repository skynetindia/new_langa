@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Aggiungi sconto</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/tassonomie/sconti/store', 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="name">Nome <span class="required">(*)</span></label>
		<input value="{{ old('name') }}" class="form-control" type="text" name="name" id="name" placeholder="Nome"><br>
		
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
            <label for="tipoente">Tipo ente <span class="required">(*)</span></label>
            <select name="tipoente" class="form-control" id="tipoente" style="color:#ffffff">
			<option style="background-color:white"></option>
			@foreach($tipienti as $tipo)
                            <option value="{{$tipo->id}}" style="background-color:{{$tipo->color}};color:#ffffff">{{$tipo->name}}</option>
			@endforeach
            </select>
            <br>
		<script>
		$('#tipoente').on("change", function() {
			var yourSelect = document.getElementById( "tipoente" );
			document.getElementById("tipoente").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<label for="sconto">Sconto <span class="required">(*)</span></label>
		<input value="{{ old('sconto') }}" class="form-control" type="number" name="sconto" id="sconto" placeholder="Sconto"><br>
	</div>
        
        <div class="col-md-12">
            <label for="descrizione">Descrizione</label>
                <textarea value="{{ old('descrizione') }}" class="form-control" type="text" name="descrizione" id="descrizione" placeholder="Descrizione"></textarea><br>
        </div>
        
	<div class="col-xs-12">
        <button type="submit" class="btn btn-warning">Salva</button>
        <div class="space50"></div>
	</div>
    <?php echo Form::close(); ?>  
    <div class="footer-svg">
	<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>

@endsection