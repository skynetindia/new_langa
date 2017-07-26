@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Aggiungi optional</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/tassonomie/optional/store', 'files' => true,'id'=>'frmoptional')) ?>
	{{ csrf_field() }}
   <div class="col-md-12 text-right">
    <div class="quiz-check">
	   <span>Escludi da Quiz? (si/no)</span><div class="switch"><input value="1" <?php if(isset($optional->escludi_da_quiz) && $optional->escludi_da_quiz=='1'){ echo 'checked';}?> class="" type="checkbox" name="escludi_da_quiz" id="escludi_da_quiz"><label for="escludi_da_quiz"></label></div>
    </div>
    </div>
    <div class="col-md-4">
		<label for="code">Nome breve <span class="required">(*)</span></label>
		<input value="{{ old('code') }}" class="form-control" type="text" name="code" id="code" placeholder="Nome breve"><br>
        <div class="row">
        <div class="col-md-6">
        <label for="logo">Logo</label>
		<?php echo Form::file('logo', ['class' => 'form-control']); ?>
        </div>
        <div class="col-md-6">
        <label for="immagine">Immagine</label>
		<?php echo Form::file('immagine', ['class' => 'form-control']); ?>
        </div></div><br>
		<label for="frequenza">Frequenza <span class="required">(*)</span></label>
        <select name="frequenza" class="form-control">
            @foreach($frequenze as $frequenza)
                @if($frequenza->id == old('code'))
                <option selected value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
                @else
                <option value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
                @endif
            @endforeach
        </select><br>
	</div>	
	<!-- colonna centrale -->
    <div class="col-md-4">
    	<label for="description">Descrizione </label>
        <textarea class="form-control cust-height" name="description" id="description" rows="5" placeholder="Descrizione">{{ old('description') }}</textarea><br />
        <div class="row">
        <div class="col-md-6">
        <label for="price">Prezzo listino base (€)</label>
		<input value="{{ old('price') }}" class="form-control" type="text" name="price" id="price" placeholder="Prezzo listino base">
        </div>
         <div class="col-md-6">
        <label for="price">Sconto listino Reseller (%)</label>
		<input value="{{ old('sconto_reseller') }}" class="form-control" type="text" name="sconto_reseller" id="sconto_reseller" placeholder="Sconto listino Reseller "></div></div>
		<?php /*<label for="label">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $optional->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome"><br>*/?>         
	</div>
    <div class="col-md-4">
	    <label for="description">Descrizione Quiz </label>
        <textarea class="form-control cust-height" name="description_quize" id="description_quize" rows="5" placeholder="Descrizione Quize">{{ old('description_quize') }}</textarea><br />
        <div class="row">
        <div class="col-md-6">
        <label for="dipartimento">Dipartimento <span class="required">(*)</span></label>
        <select name="dipartimento" class="form-control">      
            @foreach($dipartimenti as $dipartimento)
                @if($dipartimento->id == old('dipartimento'))
                <option selected value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                @else
                <option value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                @endif
            @endforeach
        </select>
        </div>
        <div class="col-md-6">
        <label for="lavorazione">Lavorazione </label>
        <select name="lavorazione" class="form-control">
        	<option value="0">Seleziona Lavorazione</option>
            @foreach($lavorazioni as $lavorazioni)
                @if($lavorazioni->id == old('lavorazione'))
                <option selected value="{{$lavorazioni->id}}">{{$lavorazioni->nome}}</option>
                @else
                <option value="{{$lavorazioni->id}}">{{$lavorazioni->nome}}</option>
                @endif
            @endforeach
        </select></div></div>
	</div>	
	<div class="col-xs-12">		
		<button type="submit" class="btn btn-warning">Salva</button>
	</div>
    <div class="footer-svg">
	<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
    <?php echo Form::close(); ?>  
     <script>
	 $(document).ready(function() {
		 $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || ((element.files[0].size/1024/1024).toFixed(2) <= param)
}, 'File size must be less than {0}');

        // validate signup form on keyup and submit
        $("#frmoptional").validate({
            rules: {
                code: {
                    required: true,
                    maxlength: 35
                },
                frequenza: {
					required: true
                },
                dipartimento: {
                    required: true
                },
				logo:{
					filesize: 2
				},
				immagine:{
					filesize: 2
				}
			},
            messages: {
                code: {
                    required: "Inserisci un breve nome",
                    maxlength: "Il nome abbreviato deve essere inferiore a 35 caratteri"
                },
                frequenza: {
					required: "Seleziona una frequenza"
                },
                dipartimento: {
                    required: "Seleziona un reparto"
                },
				logo:{
					filesize: "file size less than 2 MB"
				},
				immagine:{
					filesize: "file size less than 2 MB"
				}
            }
        });
	  });
    </script>

@endsection