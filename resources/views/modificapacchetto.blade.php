@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{ trans('messages.keyword_editpack') }} </h1><hr>
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
<?php echo Form::open(array('url' => '/admin/tassonomie/update/pacchetto' . "/$pacchetto->id", 'files' => true, 'id'=>'package_editform', 'name'=>'package_editform')) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="code"> {{ trans('messages.keyword_code') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $pacchetto->code }}" class="form-control" type="text" name="code" id="code" placeholder=" {{ trans('messages.keyword_code') }} Codice"><br>
		
		
	</div> 
	<!-- colonna centrale -->
	<div class="col-md-4">
		<label for="label"> {{ trans('messages.keyword_name') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $pacchetto->label }}" class="form-control" type="text" name="label" id="label" placeholder=" {{ trans('messages.keyword_name') }} Nome"><br>
                
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
                <label for="logo"> {{ trans('messages.keyword_logo') }} </label>
		<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
	</div>

        <div class="col-md-12">
            <div class="table-responsive">
                <label for="optional[]">{{ trans('messages.keyword_optional') }} </label>
                <table class="table table-bordered">
                    <tr>
                        <?php $check = true; ?>
                    @for($i = 0; $i < count($optional); $i++)
                        @if($i % 4 == 0)
                            </tr><tr>
                        @endif
                        <td class="ciao">
                            @foreach($optionalselezionati as $optsel)
                                @if($optsel->optional_id == $optional[$i]->id)
                                    <input checked type="checkbox" name="optional[]" id="optional" value="<?php echo $optional[$i]->id; ?>">
                                    <label for="" > </label><?php echo " " . $optional[$i]->label; ?>
                                    <?php $check = false; ?>
                                @endif
                            @endforeach
                            @if($check==true)
                                <input type="checkbox" name="optional[]" id="optional[]" value="<?php echo $optional[$i]->id; ?>"><?php echo " " . $optional[$i]->label; ?>
                            @endif
                            <?php $check = true; ?>
                        </td>
                    @endfor
                    </tr>
                </table>
            </div>
        </div>    
        
	<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">
		
		<button type="submit" class="btn btn-primary"> {{ trans('messages.keyword_save') }} </button>
	</div>
    <?php echo Form::close(); ?>  

<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
        
@endsection