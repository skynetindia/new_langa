@extends('adminHome')
@section('page') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 
<!--<link href="{{asset('build/js/jquery.datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('build/js/jquery.datetimepicker.full.js')}}"></script>-->
<h1><?php echo (isset($language_transalation->language_key) ) ? trans('messages.keyword_edit_language_translation') : trans('messages.keyword_add').' '.trans('messages.keyword_language_translation');  ?></h1>
<hr>
@if(!empty(Session::get('msg'))) 
<script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script> 
@endif
@include('common.errors')
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
  <div class="col-lg-12">
    <div class="form-wrap">
      <div class="col-sm-6">
        <div class="form-group">
          <label>{{trans('messages.keyword_keyword_title')}}<span class="required">*</span></label>
          <input type="text" class="form-control" name="keyword_title" id="keyword_title" value="<?php if(isset($language_transalation->language_label)) echo $language_transalation->language_label;?>">
           <input type="hidden" name="hdSaveType" id="hdSaveType" value="0"> 
           <input type="hidden" name="nextrecordid" value="{{isset($NextRecord[0]->id) ? $NextRecord[0]->id : '' }}">
           <input type="hidden" name="previouserecordid" value="{{isset($PreviouseRecord[0]->id) ? $PreviouseRecord[0]->id : '' }}">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <ul class="nav nav-tabs">
            @foreach ($language as $key => $val)
            <li class="<?php echo ($val->code=='en')?'active':'';?>"><a data-toggle="tab" href="<?php echo '#'.$val->code;?>"><?php echo $val->name;?></a></li>
            @endforeach
          </ul>
          <br>
          <div class="tab-content"> @foreach ($language as $key => $val)
            <?php 
									$phase_data = array();									
                                      if(isset($language_transalation->language_key) && $language_transalation->language_key != ""){
										 $phase_data = DB::table('language_transalation')->where('code',$val->code)->where('language_key',$language_transalation->language_key)->first();
                                      }
                                  ?>
            <div id="<?php echo $val->code;?>" class="tab-pane fade <?php echo ($val->code=='en')?'in active':'';?>">
            <div class="row">
              <div class="col-sm-12">
                <label> {{trans('messages.keyword_language_phrases')}}<span class="required">*</span> </label>
                <textarea class="form-control" rows="10"  name="<?php echo $val->code.'_keyword_desc';?>" id="<?php echo $val->code.'_keyword_desc';?>"><?php if(isset($phase_data->language_value) && $phase_data->language_value != ""){ echo $phase_data->language_value;}?>
</textarea>
              </div>
              </div>
            </div>
            @endforeach </div>
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
<div class="col-md-12 text-right">
<div class="space10"></div>
  @if(isset($language_transalation->language_key) && isset($PreviouseRecord[0]->id))
  <button id="btnSubmitPreviouse" type="submit" class="btn btn-primary">{{trans('messages.keyword_save_&_previous')}}</button>  
  @endif
  <button onclick="mostra2()" id="btnSubmitEnti" type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
  @if(isset($language_transalation->language_key) && isset($NextRecord[0]->id))
  <button id="btnSubmitNext" type="submit" class="btn btn-primary">{{trans('messages.keyword_save_&_next')}}</button>  
  @endif
  @if(isset($language_selected->id))
  <a href="{{url('/admin/languagetranslation/').'/'.$language_selected->id}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a>
  @endif
</div>
<?php echo Form::close(); ?> 
<script>
function punto() {
	$('#prova').val($('#pac-input').val());
}
$('.ciao').on("click", function() {
	$(this).children()[0].click();
});

$('#btnSubmitNext').on("click", function() {
  $("#hdSaveType").val('1');//Next
});
$('#btnSubmitPreviouse').on("click", function() {
  $("#hdSaveType").val('2');//Previouse
});

/*$('#btnSubmiTop').on("click", function() {
	$("#btnSubmitEnti").click();
});*/
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
                    required: "{{trans('messages.keyword_please_enter_a_label')}}",
                    maxlength: "{{trans('messages.keyword_label_must_be_less_than_50_characters')}}"
                }
            }
        });
	  });
    </script> 
@endsection