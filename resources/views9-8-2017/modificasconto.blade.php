@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{ isset($sconto->id) ? trans('messages.keyword_discedit') : trans('messages.keyword_discadd')  }} </h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<?php 
if(isset($sconto->id)){
  echo Form::open(array('url' => '/admin/tassonomie/update/sconto' . "/$sconto->id", 'files' => true, 'id' => 'scontiform', 'name'=>'scontiform')); 
}
else {
  echo Form::open(array('url' => '/admin/tassonomie/sconti/store', 'files' => true, 'id' => 'scontiform', 'name'=>'scontiform')); 
}
?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="name">{{ trans('messages.keyword_name') }} <span class="required">(*)</span></label>
		<input value="{{ isset($sconto->name) ? $sconto->name : old('name')  }}" class="form-control" type="text" name="name" id="name" placeholder="{{ trans('messages.keyword_name') }} "><br>		
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
            <label for="tipoente">{{ trans('messages.keyword_entitytype') }}<span class="required">(*)</span></label>
            <select name="tipoente" class="form-control" id="tipoente" style="color:#ffffff">
                        <?php $check = false; ?>
			<option style="background-color:white"></option>
			@foreach($tipienti as $tipo)
        @if(isset($entisconti))
                            @foreach($entisconti as $en)
                                @if($en->id_tipo == $tipo->id)
                                    <option selected value="{{$tipo->id}}" style="background-color:{{$tipo->color}};color:#ffffff">{{$tipo->name}}</option>
                                    <?php $check = true; ?>
                                    @break;
                                @endif
                            @endforeach
                            @endif

                            @if($check==false)
                                <option value="{{$tipo->id}}" style="background-color:{{$tipo->color}};color:#ffffff">{{$tipo->name}}</option>
                            @endif 
                            <?php $check = false; ?>
			@endforeach
            </select>
            <br>
		<script>
                    var yourSelect = document.getElementById( "tipoente" );
			document.getElementById("tipoente").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$('#tipoente').on("change", function() {
			var yourSelect = document.getElementById( "tipoente" );
			document.getElementById("tipoente").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<label for="sconto">{{ trans('messages.keyword_discount') }} <span class="required">(*)</span></label>
		<input value="{{ isset($sconto->sconto) ? $sconto->sconto : old('sconto') }}" class="form-control" type="number" name="sconto" id="sconto" placeholder="{{ trans('messages.keyword_discedit') }} Sconto"><br>
	</div>        
    <div class="col-md-12">
        <label for="descrizione">{{ trans('messages.keyword_description') }}</label>
         <textarea class="form-control" type="text" name="descrizione" id="descrizione" placeholder=" {{ trans('messages.keyword_discedit') }}Descrizione">{{ isset($sconto->descrizione) ? $sconto->descrizione : old('descrizione')}}</textarea><br>
    </div>
    <div class="col-xs-12">
  <button type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }}</button>
  <div class="space50"></div>
</div>	
    <?php echo Form::close(); ?>  
<div class="footer-svg">
    <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
<script>
$(document).ready(function() {
     $("#scontiform").validate({            
            rules: {
                name: {
                    required: true
                },
                tipoente: {
                    required: true
                },
                sconto: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                name: {
                    required: "{{trans('messages.keyword_please_enter_a_name')}}"
                },
                tipoente: {
                    required: "{{trans('messages.keyword_please_select_an_entity_type')}}"
                },
                sconto: {
                    required: "{{trans('messages.keyword_please_enter_a_discount')}}",
                    digits: "{{ trans('messages.keyword_only_digits_allowed')}}"
                }
            }
        });
   });
     </script>
        
@endsection