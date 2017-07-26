@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Modifica pacchetto</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/tassonomie/update/pacchetto' . "/$pacchetto->id", 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
        <div class="form-group">
            <label for="code">Codice <span class="required">(*)</span></label>
            <input value="{{ $pacchetto->code }}" class="form-control" type="text" name="code" id="code" placeholder="Codice">
        </div>
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
     <div class="form-group">
		<label for="label">Nome <span class="required">(*)</span></label>
		<input value="{{ $pacchetto->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome">
	</div>
    </div>
	<!-- colonna a destra -->
	<div class="col-md-4">
     <div class="form-group">
                <label for="logo">Logo</label>
			<?php echo Form::file('logo', ['class' => 'form-control']); ?>
        </div>
	</div>

        <div class="col-md-12">
            <div class="table-responsive">
                <label for="optional[]">Optional</label>
                <table class="table table-bordered">
                    <tr>
                        <?php $check = true; ?>
                    @for($i = 0; $i < count($optional); $i++)
                        @if($i % 4 == 0)
                            </tr>
                            <tr>
                        @endif
                        <td class="">
                            @foreach($optionalselezionati as $optsel)
                                @if($optsel->optional_id == $optional[$i]->id)
                                    <input checked type="checkbox" name="optional<?php echo $optional[$i]->id; ?>" id="optional<?php echo $optional[$i]->id; ?>" value="<?php echo $optional[$i]->id; ?>"> <label for="optional<?php echo $optional[$i]->id; ?>"> <?php echo " " . $optional[$i]->label; ?></label>
                                    <?php $check = false; ?>
                                @endif
                            @endforeach
                            @if($check==true)
                                <input type="checkbox" name="optional<?php echo $optional[$i]->id; ?>" id="optional<?php echo $optional[$i]->id; ?>" value="<?php echo $optional[$i]->id; ?>"> <label for="optional<?php echo $optional[$i]->id; ?>"><?php echo " " . $optional[$i]->label; ?></label>
                            @endif
                            <?php $check = true; ?>
                        </td>
                    @endfor
                    </tr>
                </table>
            </div>
        </div>    
        
	<div class="col-md-12">
		<button type="submit" class="btn btn-warning">Salva</button>
        <div class="space50"> </div>
	</div>
    <div class="footer-svg">
		<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
	</div>
    <?php echo Form::close(); ?>  

<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
        
@endsection