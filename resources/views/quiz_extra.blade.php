@extends('adminHome')
@section('page')
<div class="res-tassonomie-enti">
<h1>{{trans('messages.keyword_quiz_extra')}}</h1><hr>
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
<form action="{{url('/admin/quiz/addratetype')}}" method="post" id="frmentiadd" name="frmentiadd">
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
	<?php /*<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
			<input class="form-control color no-alpha" value="#f37f0d" name="color" />
		</div>
	</div>*/?>
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
<form action="{{url('/admin/quiz/updatedeleteratetype')}}" method="post" id="frmentiedit_type">
<input type="hidden" id="actiontype" name="action" value="update">
<div class="table-responsive">
    <table class="table table-striped table-bordered text-right checkbox-tbl">
      @foreach($type as $types)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$types->rating_id}}">            
            <table class="table sub-table">
              <tr>
                <td>
                <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$types->rating_id}}]" id="chktasentitype_{{$types->rating_id}}" value="{{$types->rating_id}}">
                <label for="chktasentitype_{{$types->rating_id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$types->rating_id}}]" id="name" value="<?php echo ($types->language_key != "") ? trans('messages.'.$types->language_key) : $types->titolo; ?>">
                <input type="hidden" name="langkey[{{$types->rating_id}}]" value="{{$types->language_key}}"></td>
                <td><input type="text" class="form-control" name="description[{{$types->rating_id}}]" value="{{$types->descrizione}}"></td>
                <td><input type="text" class="form-control disabled" name="color[{{$types->rating_id}}]" value="{{$types->avg_rate}}"></td>
                <td><input type="text" class="form-control disabled" name="color[{{$types->rating_id}}]" value="{{$types->tot_counter}}"></td>
                <td><input type="button" onclick="SingleTaxonomiesAction('{{$types->rating_id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$types->rating_id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
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
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
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
  <legend> {{ trans('messages.keyword_font_family') }} </legend>
  <h4>{{ trans('messages.keyword_add_font_family')}}</h4>
<form action="{{url('/admin/quiz/addfontfamily')}}" method="post" id="frmfontfamilyadd" name="frmfontfamilyadd">
    {{ csrf_field() }}
  <div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
      <div class="form-group">
       <input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}">
      </div>
     </div>    
    <div class="text-right res-left">
      <input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">    
    </div>
  </div>
</form>

<h4>{{trans('messages.keyword_edit_font_family')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chkfontfamilyeall" name="chkfontfamilyeall" value="1" type="checkbox">
     <label for="chkfontfamilyeall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllFontFamilyAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllFontFamilyAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
<!-- This forms used to edit/delete both actions  -->  
<form action="{{url('/admin/quiz/updatedeletefontfamily')}}" method="post" id="frmfontfamily">
<input type="hidden" id="actionfontfamily" name="action" value="update">
<div class="table-responsive">
    <table class="table table-striped table-bordered text-right checkbox-tbl">
      @foreach($font_family as $types)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$types->id}}">            
            <table class="table sub-table">
              <tr>
                <td><input type="checkbox" class="form-control chkfontfamily" name="chktasentitype[{{$types->id}}]" id="chkfontfamily_{{$types->id}}" value="{{$types->id}}">
                <label for="chkfontfamily_{{$types->id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$types->id}}]" id="name" value="<?php echo $types->family; ?>"></td>
                <td><input type="button" onclick="SingleFontFamilyAction('{{$types->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleFontFamilyAction('{{$types->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
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
   $("#frmfontfamily").validate({            
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
  $("#chkfontfamilyeall").click(function () {
     $('.chkfontfamily').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chkfontfamily").click(function () {        
    addremoveclass();
 });
  function SingleFontFamilyAction(id,action) {
    $("#chkfontfamily_"+id).prop('checked', true);
    $("#actionfontfamily").val(action);
    $("#frmfontfamily").submit();
  }
function AllFontFamilyAction(action) {
if ($("#frmfontfamily input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actionfontfamily").val(action);
  $( "#frmfontfamily").submit();  
 }
 else {
    alert("{{trans('messages.keyword_select_at_least_one_record')}}");
 }
}
/*function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}*/
</script>
</fieldset>
<div class="space40"></div>
<fieldset>
  <legend> {{ trans('messages.keyword_font_size') }} </legend>
  <h4>{{ trans('messages.keyword_add_font_size')}}</h4>
<form action="{{url('/admin/quiz/addfontsize')}}" method="post" id="frmfontsizeadd" name="frmfontsizeadd">
    {{ csrf_field() }}
  <div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
      <div class="form-group">
       <input type="number" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}">
      </div>
     </div>    
    <div class="text-right res-left">
      <input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">    
    </div>
  </div>
</form>

<h4>{{trans('messages.keyword_edit_font_size')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chkfontsizeeall" name="chkfontsizeeall" value="1" type="checkbox">
     <label for="chkfontsizeeall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllFontSizeAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllFontSizeAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
<!-- This forms used to edit/delete both actions  -->  
<form action="{{url('/admin/quiz/updatedeletefontsize')}}" method="post" id="frmfontsize">
<input type="hidden" id="actionfontsize" name="action" value="update">
<div class="table-responsive">
    <table class="table table-striped table-bordered text-right checkbox-tbl">
      @foreach($font_size as $types)
      <tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$types->id}}">            
            <table class="table sub-table">
              <tr>
                <td><input type="checkbox" class="form-control chkfontsize" name="chktasentitype[{{$types->id}}]" id="chkfontsize_{{$types->id}}" value="{{$types->id}}">
                <label for="chkfontsize_{{$types->id}}"></label></td>
                <td><input type="number" class="form-control" name="name[{{$types->id}}]" id="name" value="<?php echo $types->size; ?>"></td>
                <td><input type="button" onclick="SingleFontSizeAction('{{$types->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleFontSizeAction('{{$types->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
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
   $("#frmfontsize").validate({            
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
  $("#chkfontsizeeall").click(function () {
     $('.chkfontsize').not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".chkfontsize").click(function () {        
    addremoveclass();
 });
  function SingleFontSizeAction(id,action) {
    $("#chkfontsize_"+id).prop('checked', true);
    $("#actionfontsize").val(action);
    $("#frmfontsize").submit();
  }
function AllFontSizeAction(action) {
  if ($("#frmfontsize input:checkbox:checked").length > 0) {    
    if(action == 'delete'){
      var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
      if (!confirmation) {
        return false;
      }        
  }
    $("#actionfontsize").val(action);
    $( "#frmfontsize").submit();  
  }
  else {
      alert("{{trans('messages.keyword_select_at_least_one_record')}}");
   }
}
/*function addremoveclass(){
  $(".table input[type=checkbox]").each(function() {
    if(false == $(this).prop("checked")) { 
        $(this).closest("tr").removeClass("selected");
     }
     else {
          $(this).closest("tr").addClass("selected");
    } 
  });
}*/
</script>
</fieldset>
</div>
<script>
	function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
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
   $("#frmfontfamilyadd").validate({            
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