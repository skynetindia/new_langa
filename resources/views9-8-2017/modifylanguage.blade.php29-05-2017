@extends('adminHome')
@section('page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>
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
table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
}
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    padding: 15px;
}
</style>
<script type="text/javascript">
 
 $(document).ready(function() {
  $("#dipartimento").change(function(){
    if( $(this).val() == 1) {
        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 3) {
        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();
    } else if( $(this).val() == 4) {
        $("#sconto_section").show();      
        $("#rendita").show();
        $("#rendita_reseller").hide();
        $("#zone").show();
    } else {
      $("#sconto_section").show(); 
      $("#rendita").show();
      $("#rendita_reseller").show();
      $("#zone").show();
    }
  });
});
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
    <script type="text/javascript">
        $(document).on("click", "#profilazioneinterna", function () {
            
            if ($(this).is(":unchecked")) {
                $("#rendita").show();
            } else {
                $("#rendita").hide();
            }
        });
    </script>
@include('common.errors')
  <h1>Modifica language</h1><hr>
  <?php 
  if(isset($language) && !empty($language)){
  	echo Form::open(array('url' => '/admin/update/language' . "/$language->id", 'files' => true, 'id' => 'frmLanguage'));
  }
  else {
   	echo Form::open(array('url' => '/admin/update/language', 'files' => true, 'id' => 'frmLanguage'));
  }
   ?>
    {{ csrf_field() }}
    <!-- colonna a sinistra -->
   <div class="col-md-4">
    <label for="name">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
    <input type="hidden" name="language_id" value="{{ isset($language->id) ? $language->id : "" }}">
    <input value="{{ isset($language->name) ? $language->name : old('name') }}" class="form-control" maxlength="50" type="text" name="name" id="name" placeholder="inserisci il nome"><br>
    <label for="colore">Original Nome</label>
    <input value="{{isset($language->original_name) ? $language->original_name : old('original_name')}}" maxlength="50" class="form-control no-alpha" type="text" name="original_name" id="original_name" placeholder="Original Nome">
<br>
    <br>
    </div>
     <div class="col-md-4">
    <label for="name">Code <p style="color:#f37f0d;display:inline">(*)</p></label>
    <input value="{{ isset($language->code) ? $language->code : old('code') }}" class="form-control" maxlength="3" type="text" name="code" id="code" placeholder="inserisci il code"><br>
    <label for="colore">Icon</label>
    <?php echo Form::file('icon', ['class' => 'form-control']); ?>
    </div>
     <div class="col-md-4">
         <label for="colore">Is Default?
    <input type="checkbox" name="is_default" id="is_default" value="1" <?php if(isset($language->is_default) && $language->is_default == '1'){ echo 'checked';} ?> class="form-control no-alpha" />
    </label>

     </div>
    <!-- colonna centrale -->

<script type="text/javascript">  
  $('.reading').click(function () {    
       // $('#sublettura').prop('checked', this.checked); 
        var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });
  $('.writing').click(function () {    
       var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });
   $(document).ready(function() {

        // validate signup form on keyup and submit
        $("#frmLanguage").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                code: {
                    required: true,
					minlength : 2,
                    maxlength: 3
                }
            },
            messages: {
                name: {
                    required: "Please enter a language name",
                    maxlength: "Language Name must be less than 50 charcters"
                },
                code: {
                    required: "Please enter a code",
					minlength : "Code must 2 characters long",
                    maxlength: "Code must 3 characters long"
                }
            }
        });
        $.validator.setDefaults({
        	ignore: []
    	});
   });

</script>
	<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">
		<button type="submit" class="btn btn-primary">Salva</button>
    {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-danger']) !!}
	</div>
    <?php echo Form::close(); ?>  
<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection