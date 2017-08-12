@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_frequency')}}</h1><hr>
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
<legend>{{trans('messages.keyword_add_frequency')}}</legend>
<form action="{{url('/admin/frequency/add')}}" method="post" id="frmemotionalest">
    {{ csrf_field() }}
    <div class="row">
	<div class="col-md-4">
    <div class="form-group">
      <labe>{{trans('messages.keyword_name')}} <input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"></labe>
    </div>		
	</div>
	<div class="col-md-4">
    <div class="form-group">
      <labe>{{trans('messages.keyword_description')}}<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"></labe>
    </div> 
	</div>
	<div class="col-md-4">
    <div class="form-group">
      <labe>{{trans('messages.keyword_days')}}<input type="text" class="form-control" name="rinnovo" maxlength="4" value="1"></labe>
    </div>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>
<h4>{{trans('messages.keyword_edit_frequency')}}</h4>
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
<form action="{{url('/admin/frequency/update')}}" method="post" id="frmemotionalestEdit">
<input type="hidden" id="actiontype" name="action" value="update">
<div class="table-responsive">
		<table class="table table-striped table-bordered text-right">
	@foreach($frequency as $frequencies)
	<tr>
        <td>
            {{ csrf_field() }}
            <input type="hidden" name="id[]" value="{{$frequencies->id}}">
            <table class="table sub-table">
              <tr>
                <td><input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$frequencies->id}}]" id="chktasentitype_{{$frequencies->id}}" value="{{$frequencies->id}}"><label for="chktasentitype_{{$frequencies->id}}"></label></td>
                <td><input type="text" class="form-control" name="name[{{$frequencies->id}}]" id="name" value="<?php echo ($frequencies->language_key != "") ? trans('messages.'.$frequencies->language_key) : $frequencies->nome; ?>">
                <input type="hidden" name="langkey[{{$frequencies->id}}]" value="{{$frequencies->language_key}}"></td>
                <td><input type="text" class="form-control" name="description[{{$frequencies->id}}]" value="{{$frequencies->descrizione}}"></td>
                <td><input type="text" class="form-control" name="rinnovo[{{$frequencies->id}}]" maxlength="7" value="{{$frequencies->rinnovo}}"></td><td><input type="button" onclick="SingleTaxonomiesAction('{{$frequencies->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$frequencies->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>

                <?php /*<td><input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/frequency/delete/id' . '/' . $frequencies->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>*/?>
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
           $("#frmemotionalestEdit").validate({            
                      rules: {
                          "name[]": {
                              required: true,
                          },
                          "rinnovo[]": {
                              required: true,
                              digits:true
                          }
                      },
                      messages: {
                          "name[]": {
                              required: "{{trans('messages.keyword_please_enter_a_name')}}"
                          },
                          "rinnovo[]": {
                              required: "{{trans('messages.keyword_please_enter_a_frequency_days')}}",
                              digits:"{{trans('messages.keyword_only_digits_allowed')}}"
                          }
                      }
                  });
          });
          </script>
</fieldset>
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
   $("#frmemotionalest").validate({            
              rules: {
                  name: {
                      required: true,
                  },
                  rinnovo: {
                    required: true,
                    digits:true
                  }                    
              },
              messages: {
                  name: {
                      required: "{{trans('messages.keyword_please_enter_a_name')}}"
                  },
                  rinnovo: {
                    required: "{{trans('messages.keyword_please_enter_a_frequency_days')}}",
                    digits:"{{trans('messages.keyword_only_digits_allowed')}}"
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
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
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
function addremoveclass() {
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