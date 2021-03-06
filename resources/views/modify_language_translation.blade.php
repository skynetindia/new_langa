@extends('adminHome')
@section('page') 
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

<?php /*<link rel="stylesheet" href="{{ asset('build/css/bootstrap-table.min.css') }}">
<script src="{{ asset('build/js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('build/js/bootstrap-table-it-IT.min.js') }}"></script>*/?>

  
<!--<link href="{{asset('build/js/jquery.datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('build/js/jquery.datetimepicker.full.js')}}"></script>-->
<div class="row">
<div class="col-md-9 col-sm-12 col-xs-12">
<h1><?php echo (isset($language_transalation->language_key) ) ? trans('messages.keyword_edit_language_translation') : trans('messages.keyword_add').' '.trans('messages.keyword_language_translation');  ?></h1>
</div>
<div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group admin-dropdown">
          <label>{{trans('messages.keyword_search')}}</label>
          <input type="text" class="form-control" id="txtsearchpharse" value="">           
        </div>
      </div>
      </div>
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
<?php /*<strong><hr></strong>
<a href="{{ url('/admin/add/languagetranslation') }}" id="create" class="btn btn-warning" name="create" title=" {{trans('messages.keyword_create_a_new_language')}}"><i class="fa fa-plus"></i>  </a>

<a onclick="multipleAction('modify');" id="modifica" class="btn btn-primary" name="update" title=" {{trans('messages.keyword_edit_last_selected_format')}}"><i class="fa fa-pencil"></i>  </a>
  <?php /*<a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica gli enti selezionati"><i class="fa fa-files-o"></i></button>
</a>*?>
  <a id="delete" onclick="multipleAction('delete');" class="btn btn-danger" name="remove" title=" {{trans('messages.keyword_delete_selected_format')}} "><i class="fa fa-trash"></i></a> 

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php  echo url('admin/languagetranslation/json').'/'.$language_transalation->code;?>" data-classes="table table-bordered" id="table">
  <thead>
  <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
    <th data-field="language_label" data-sortable="true">{{trans('messages.keyword_language_label')}}</th>
    <th data-field="language_value" data-sortable="true">{{trans('messages.keyword_language_phase')}}</th>
    <th data-field="language_key" data-sortable="true">{{trans('messages.keyword_phrase_key')}}</th>
      </thead>
</table>
*/?>
<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
  var cod = $(el[0]).children()[0].innerHTML;
  if (!selezione[cod]) {
        $('#table tr.selected').removeClass("selected");       
    $(el[0]).addClass("selected");
    selezione[cod] = cod;
    indici[n] = cod;
    n++;
  } else {
    $(el[0]).removeClass("selected");
    selezione[cod] = undefined;
    for(var i = 0; i < n; i++) {
      if(indici[i] == cod) {
        for(var x = i; x < indici.length - 1; x++)
          indici[x] = indici[x + 1];
        break;  
      }
    }
    n--;
        $('#table tr.selected').removeClass("selected");       
        $(el[0]).addClass("selected");
        selezione[cod] = cod;
        indici[n] = cod;
        n++;
  }
});


function check() {

  return confirm("{{trans('messages.keyword_are_you_sure_you_want_to_delete:')}}: " + n + " {{trans('messages.keyword_language_phrases')}}?");
}
function multipleAction(act) {
  var link = document.createElement("a");
  var clickEvent = new MouseEvent("click", {
      "view": window,
      "bubbles": true,
      "cancelable": false
  });
        var error = false;
    switch(act) {
      case 'delete':
                                
        link.href = "{{ url('/admin/languagetranslation/delete') }}" + '/';
        if(check() && n!= 0) {
                        for(var i = 0; i < n; i++) {                            
                            $.ajax({
                                type: "GET",
                                url : link.href + indici[i],
                                error: function(url) {
                                    
                                    if(url.status==403) {
                                        link.href = "{{ url('/admin/languagetranslation/delete') }}" + '/' + indici[n];
                                        link.dispatchEvent(clickEvent);
                                        error = true;
                                    }
                                }                                
                            });
                        }                        
                        selezione = undefined;
                        if(error === false)
                            setTimeout(function(){location.reload();},100*n);
              
            n = 0;
                    }
          
      break;
      case 'modify':
                if(n != 0) {
          n--;
          link.href = "{{ url('/admin/modify/languagetranslation') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
            case 'newclient':
                if(n!=0) {
                    n--;
                    link.href = "{{ url('/enti/nuovocliente/corporation') }}" + '/' + indici[n];
                    n = 0;
                    selezione = undefined;
                    link.dispatchEvent(clickEvent);
                }
            break;
      case 'duplicate':
        link.href = "{{ url('/enti/duplicate/corporation') }}" + '/';
                                for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                          window.location.href = "{{ url('/enti/duplicate/corporation') }}" + '/' + indici[n];
                                                    error = true;
                                                } 
                                            }
                                        });
                                    }
                                    selezione = undefined;
                                    
                                if(error === false)
                                    setTimeout(function(){location.reload();},100*n);
                  
                n = 0;
      break;
    }
}

</script> 

<script>
  var $j = jQuery.noConflict();
  $j( function() {
    $j("#txtsearchpharse").autocomplete({
      source: function( request, response ) {
        $j.ajax( {
          url: "{{url('admin/searchtranslation/')}}",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        var id = ui.item.id;
        var url = '{{url('admin/modify/languagetranslation')}}';        
        window.location.href= url+'/'+id;        
      }
    } );
  } );
  </script>

@endsection