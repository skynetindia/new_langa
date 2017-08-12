@extends('adminHome')
@section('page')

<div class="res-taxonomies-quotes">

<h1>{{trans('messages.keyword_taxonomies_estimates')}}</h1><hr>
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<fieldset>
<legend>{{trans('messages.keyword_emotional_state')}}</legend>
<form action="{{url('/admin/taxonomies/addestimates')}}" method="post" id="frmemotionalest">
    {{ csrf_field() }}
    <div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group"><input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"></div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group"><input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"></div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group"><input class="form-control color no-alpha" value="#f37f0d" name="color" /></div>
	</div>
	<div class="col-md-12 text-right res-left">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>

<h4>{{trans('messages.keyword_edit_emotional_state_quote')}}</h4>
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
<form action="{{url('/admin/taxonomies/updateestimates')}}" method="post" id="frmemotionalestEdit">
<input type="hidden" id="actiontype" name="action" value="update">
<div class="table-responsive">
		<table class="table table-striped table-bordered text-right checkbox-tbl">
	@foreach($estimates_stats as $estimatestype)
	<tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$estimatestype->id}}">
            <table class="table sub-table">
              <tr>
              <td>
                <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$estimatestype->id}}]" id="chktasentitype_{{$estimatestype->id}}" value="{{$estimatestype->id}}">
                <label for="chktasentitype_{{$estimatestype->id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$estimatestype->id}}]" id="name" value="{{$estimatestype->name}}"></td>
                <td><input type="text" class="form-control" name="description[{{$estimatestype->id}}]" value="{{$estimatestype->description}}"></td>
                <td><input type="text" class="form-control color no-alpha" name="color[{{$estimatestype->id}}]" value="{{$estimatestype->color}}"></td>
                <?php /*<td><input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/statiestimate/delete/id' . '/' . $estimatestype->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>*/?>
                <td><input type="button" onclick="SingleTaxonomiesAction('{{$estimatestype->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$estimatestype->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
              </tr>
            </table>
        </td>
      </tr>    	
	@endforeach
	</table>
	</div>
    </div>
</form>
  <script type="text/javascript">
         $(document).ready(function() {
           $("#frmemotionalestEdit").validate({            
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
   $("#frmemotionalest").validate({            
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
  $( "#frmemotionalestEdit" ).submit();
}
function AllTaxonomiesAction(action) {
if ($("#frmemotionalestEdit input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#frmemotionalestEdit").submit();  
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