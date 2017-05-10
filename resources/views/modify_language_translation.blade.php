@extends('adminHome')
@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>


<!--<link href="{{asset('build/js/jquery.datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('build/js/jquery.datetimepicker.full.js')}}"></script>-->

<h1><?php echo (isset($action) && $action=='add') ? 'Language Translation' : 'Language Translation'; ?></h1><hr>
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
@if(isset($corp->logo))
<div class="container-fluid col-md-10">
	<div style="display:inline">
 	<img src="{{url('/storage/app/images/').'/'.$corp->logo}}" style="max-width:100px; max-height:100px;display:inline"></img><h4 style="display:inline">  Codice: {{$corp->id}}</h4>
    <hr>
	</div>
</div>
<div class="col-md-2 top-right-btn"  >
		
		<button onclick="mostra2()" id="btnSubmiTop" type="submit" class="btn btn-warning">Salva</button>
	</div>
@endif
<?php 
if(isset($language_transalation->language_key)){
	echo Form::open(array('url' => '/admin/languagetranslation/update/' . $language_transalation->language_key, 'files' => true,'id'=>'frmModificaente')); 
}
else {
	echo Form::open(array('url' => '/admin/languagetranslation/store/', 'files' => true,'id'=>'frmModificaente'));
}
?>
	{{ csrf_field() }}       
	<!-- inizio chiamata -->
    <div class="row">
                                <div class="col-lg-10">
									<div class="form-wrap">
                                	<div class="col-sm-6">
                                         <div class="form-group">
                                            <label><font color="#FF0000">*</font> Keyword Title</label>
                                            <input type="text" class="form-control" name="keyword_title" id="keyword_title" value="<?php if(isset($language_transalation->language_label)) echo $language_transalation->language_label;?>">
										 </div>
                                    </div>
                                    <div class="col-sm-12">
                                      <div class="form-group"><?php									
                                      ?><ul class="nav nav-tabs">
                                      @foreach ($language as $key => $val)
                                       <li class="<?php echo ($val->code=='en')?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
                                      @endforeach
                              </ul><br>
                              <div class="tab-content">
							  @foreach ($language as $key => $val)
							  		<?php 
									$phase_data = array();									
                                      if(isset($language_transalation->language_key) && $language_transalation->language_key != ""){
										 $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$language_transalation->language_key)->first();
                                      }
                                  ?><div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code=='en')?'in active':'';?>">
                                  <div class="col-sm-6">
                                  <label><font color="#FF0000">*</font> Language Phases </label>
                                  <textarea class="form-control" style="resize:none" rows="10"  name="<?php echo $val->code.'_keyword_desc';?>" id="<?php echo $val->code.'_keyword_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?></textarea>
                                  </div>
                                  </div>
                                  @endforeach
                              </div>
                          </div>        
</div>     						 
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                                <!-- /.col-lg-6 (nested) -->
								</div>
                            </div>
  
	<!-- fine chiamata -->
	<!-- colonna a sinistra -->
	<!-- colonna centrale -->
      <!-- /partecipanti -->
 <div class="col-md-6" style="padding-top:10px;padding-bottom:10px;">
 </div>
<div class="col-md-6" style="padding-top:10px;padding-bottom:10px;text-align:right">
		
		<button onclick="mostra2()" id="btnSubmitEnti" type="submit" class="btn btn-warning">Salva</button>
	</div>
<?php echo Form::close(); ?>
<script>
function punto() {
	$('#prova').val($('#pac-input').val());
}
$('.ciao').on("click", function() {
	$(this).children()[0].click();
});
$('#btnSubmiTop').on("click", function() {
	$("#btnSubmitEnti").click();
});
// Carica i settori nel datalist dal file.json
var datalist = document.getElementById("settori");
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(response) {
	if (xhr.readyState === 4 && xhr.status === 200) {
		var json = JSON.parse(xhr.responseText);
		json.forEach(function(item) {
			var option = document.createElement('option');
			option.value = item;
			datalist.appendChild(option);
		});
    }
}
xhr.open('GET', "{{ asset('public/json/settori.json') }}", true);
xhr.send();
</script>
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	  
	  $(document).ready(function() {
        // validate signup form on keyup and submit
        $("#frmModificaente").validate({

            rules: {
                keyword_title: {
                    required: true,
                    maxlength: 50
                }
            },
            messages: {
                keyword_title: {
                    required: "Please enter Label",
                    maxlength: "Nome azienda must be less than 50 characters"
                }
            }

        });
	  });
    </script>
@endsection