@extends('adminHome')
@section('page')
<div class="res-tassonomie-enti">
<h1>{{trans('messages.keyword_taxonomy_entities')}}</h1><hr>
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">	
         $('.color').colorPicker(); // that's it   
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif


<fieldset>
<legend> {{ trans('messages.keyword_types') }} </legend>

<h4>{{ trans('messages.keyword_add_type')}}</h4>
<form action="{{url('/admin/tassonomie/new')}}" method="post" id="frmentiadd" name="frmentiadd">
    {{ csrf_field() }}
	<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}">
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}">
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
			<input class="form-control color no-alpha" value="#f37f0d" name="color" />
		</div>
	</div>
    </div>
	<div class="text-right res-left">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">    
	</div>
</form>

<h4>{{trans('messages.keyword_edit_types')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chktasentitypeall" name="chktasentitypeall" value="1" type="checkbox">
     <label for="chktasentitypeall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllTaxonomiesAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllTaxonomiesAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
  <!-- This forms used to edit/delete both actions  -->  
<form action="{{url('/admin/tassonomie/update')}}" method="post" id="frmentiedit_type">
<input type="hidden" id="actiontype" name="action" value="update">
<div class="table-responsive">
    <table class="table table-striped table-bordered text-right checkbox-tbl">
      @foreach($type as $types)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$types->id}}">            
            <table class="table sub-table">
              <tr>
                <td>
                <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$types->id}}]" id="chktasentitype_{{$types->id}}" value="{{$types->id}}">
                <label for="chktasentitype_{{$types->id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$types->id}}]" id="name" value="{{$types->name}}"></td>
                <td><input type="text" class="form-control" name="description[{{$types->id}}]" value="{{$types->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color[{{$types->id}}]" value="{{$types->color}}"></td>
                <td><input type="button" onclick="SingleTaxonomiesAction('{{$types->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$types->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
              </tr>
            </table>                    
          </td>
      </tr>
      @endforeach
    </table>
  </div>
</form>
<script type="text/javascript">
         $(document).ready(function() {
           $("#frmentiedit_type").validate({            
                      rules: {
                          "name[]": {
                              required: true,
                          }
                      },
                      messages: {
                          "name[]": {
                              required: "{{trans('messages.keyword_please_enter_a_name')}}"
                          }
                      }
                  });
          });
  $("#chktasentitypeall").click(function () {
     $('.chktasentitype').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chktasentitype").click(function () {        
    addremoveclass();
 });
function SingleTaxonomiesAction(id,action) {
  $("#chktasentitype_"+id).prop('checked', true);
  $("#actiontype").val(action);
  $( "#frmentiedit_type" ).submit();
}
function AllTaxonomiesAction(action) {
if ($("#frmentiedit_type input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#frmentiedit_type").submit();  
 }
 else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
 }
}
function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}
</script>
</fieldset>
<div class="space40"></div>
<fieldset>
<legend>{{trans('messages.keyword_emotional_state')}}</legend>
<form action="{{url('/admin/tassonomie/nuovostatoemotivo')}}" method="post" id="frmentiemotionadd" >
    {{ csrf_field() }}
    <div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
		<input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}">
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
		<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}">
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" />
		</div>
	</div>
	<div class="col-md-12 text-right res-left">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>

<h4>{{trans('messages.keyword_edit_emotional_state')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select">
    <input id="chktasentiemotionall" name="chktasentiemotionall" value="1" type="checkbox">
    <label for="chktasentiemotionall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
  <input type="button" onclick="AllEmotionalStateAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
  <input type="button" onclick="AllEmotionalStateAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
<form action="{{url('/admin/tassonomie/aggiornastatiemotivi')}}" method="post" id="frmentiemotionedit">
<input type="hidden" id="actionEmotional" name="action" value="update">
 <div class="table-responsive">
    <table class="table table-striped table-bordered text-right">
      @foreach($emotional_states_types as $emostatetye)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$emostatetye->id}}">
            <table class="table sub-table">
              <tr>
              <td>
                <input type="checkbox" class="form-control chktasentiemotion" name="chktasentiemotion[{{$emostatetye->id}}]" id="chktasentiemotion_{{$emostatetye->id}}" value="{{$emostatetye->id}}">
                <label for="chktasentiemotion_{{$emostatetye->id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$emostatetye->id}}]" id="name" value="{{$emostatetye->name}}"></td>
                <td><input type="text" class="form-control" name="description[{{$emostatetye->id}}]" value="{{$emostatetye->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color[{{$emostatetye->id}}]" value="{{$emostatetye->color}}"></td>
                <?php /*<td><input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/statiemotivi/delete/id' . '/' . $emostatetye->id)}}" class="btn btn-danger">  {{trans('messages.keyword_delete_label')}} </a></td>*/?>

                  <td><input type="button" onclick="SingleEmotionalAction('{{$emostatetye->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleEmotionalAction('{{$emostatetye->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
              </tr>
            </table>                    
          </td>
      </tr>
      @endforeach
    </table>
  </div>
</form>
<script type="text/javascript">
         $(document).ready(function() {
           $("#frmentiemotionedit").validate({            
                      rules: {
                          "name[]": {
                              required: true,
                          }
                      },
                      messages: {
                          "name[]": {
                              required: "{{trans('messages.keyword_please_enter_a_name')}}"
                          }
                      }
                  });
          });
          </script>
</fieldset>
</div>
<script>
	function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function() {
   $("#frmentiadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
   $("#frmentiemotionadd").validate({            
              rules: {
                  name: {
                      required: true,
                  }
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  }
              }
          });
   
  });
$("#chktasentiemotionall").click(function () {
     $('.chktasentiemotion').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chktasentiemotion").click(function () {        
    addremoveclass();
 });
function SingleEmotionalAction(id,action) {
  $("#chktasentiemotion_"+id).prop('checked', true);
  $("#actionEmotional").val(action);
  $( "#frmentiemotionedit").submit();
}
function AllEmotionalStateAction(action) {
  if ($("#frmentiemotionedit input:checkbox:checked").length > 0) {    
      if(action == 'delete'){
      var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
      if (!confirmation) {
        return false;
      }     
      }     
    $("#actionEmotional").val(action);
    $( "#frmentiemotionedit").submit();  
  }
  else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
  }
  
}
function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}

  </script>
@endsection