@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{ trans('messages.keyword_discadd') }} </h1><hr>
<style>
table tr td {
	text-align:left;
	
}
.table-editable {
  position: relative;
}
.table-editable .glyphicon {
  font-size: 20px;
}

.table-remove {
  color: #700;
  cursor: pointer;
}
.table-remove:hover {
  color: #f00;
}

.table-up, .table-down {
  color: #007;
  cursor: pointer;
}
.table-up:hover, .table-down:hover {
  color: #00f;
}

.table-add {
  color: #070;
  cursor: pointer;
  position: absolute;
  top: 8px;
  right: 0;
}
.table-add:hover {
  color: #0b0;
}

      #map {
        height: 100%;
		height: 400px;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
</style>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<?php echo Form::open(array('url' => '/admin/tassonomie/sconti/store', 'files' => true, 'id' => 'scontiform', 'name'=>'addscontiform')) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="name">{{ trans('messages.keyword_name') }} <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('name') }}" class="form-control" type="text" name="name" id="name" placeholder="{{ trans('messages.keyword_name') }} "><br>
		
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
            <label for="tipoente"> {{ trans('messages.keyword_entitytype') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>
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
		<label for="sconto"> {{ trans('messages.keyword_discount') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('sconto') }}" class="form-control" type="number" name="sconto" id="sconto" placeholder=" {{ trans('messages.keyword_discount') }} Sconto"><br>
	</div>
        
        <div class="col-md-12">
            <label for="descrizione"> {{ trans('messages.keyword_description') }} </label>
                <textarea value="{{ old('descrizione') }}" class="form-control" type="text" name="descrizione" id="descrizione" placeholder=" {{ trans('messages.keyword_description') }} "></textarea><br>
        </div>
        
	<div class="col-xs-6" style="padding-top:10px;padding-bottom:10px;">
		
		<button type="submit" class="btn btn-primary"> {{ trans('messages.keyword_save') }} </button>
	</div>
    <?php echo Form::close(); ?>  

     $("#scontiform").validate({
            
            rules: {
                name: {
                    required: true,
                },
                tipoente: {
                    required: true,
                },
                sconto: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a name"
                },
                tipoente: {
                    required: "Please Select a tipo ente"
                },
                sconto: {
                    required: "Please enter a sconto"
                }
            }

        });

@endsection