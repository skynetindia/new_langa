@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_taxonomies_payments')}}</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>
<fieldset>
<legend>{{trans('messages.keyword_emotional_state')}}</legend>
<form action="{{url('/admin/taxonomies/addstatepayment')}}" method="post" id="frmemotionalPayment">
    {{ csrf_field() }}
    <div class="row">
	<div class="col-md-4">
		<div class="form-group"><input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"></div>
	</div>

	<div class="col-md-4">
		<div class="form-group"><input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"></div>
	</div>

	<div class="col-md-4">
		<div class="form-group"><input class="form-control color no-alpha" value="#f37f0d" name="color" /></div>
	</div>

	<div class="col-md-12 text-right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>
@if(count($statepayments) > 0)
<h4>{{trans('messages.keyword_edit_emotional_payment_state')}}</h4>
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
<form action="{{url('/admin/tassonomie/updatestatepayment')}}" method="post" id="frmemotionalPaymentEdit">
<input type="hidden" id="actiontype" name="action" value="update">
<div class="table-responsive">
		<table class="table table-striped table-bordered text-right checkbox-tbl">
	@foreach($statepayments as $statepayment)    	
	<tr>
		<td>
				{{ csrf_field() }}
				<input type="hidden" name="id[]" value="{{$statepayment->id}}">
					<table class="table sub-table">
		              <tr>
		              <td>
        		        <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$statepayment->id}}]" id="chktasentitype_{{$statepayment->id}}" value="{{$statepayment->id}}">
		                <label for="chktasentitype_{{$statepayment->id}}"></label></td>
		                <td><input type="text" class="form-control" name="name[{{$statepayment->id}}]" id="name" value="<?php echo ($statepayment->language_key != "") ? trans('messages.'.$statepayment->language_key) : $statepayment->name; ?>">
                        <input type="hidden" name="langkey[{{$statepayment->id}}]" value="{{$statepayment->language_key}}"></td>
		                <td><input type="text" class="form-control" name="description[{{$statepayment->id}}]" value="{{$statepayment->description}}"></td>
		                <td><input type="text" class="form-control color no-alpha" name="color[{{$statepayment->id}}]" value="{{$statepayment->color}}"></td>
		                <td><input type="button" onclick="SingleTaxonomiesAction('{{$statepayment->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$statepayment->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>

		               <?php /* <td><input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
		                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/statepayment/delete/id' . '/' . $statepayment->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>*/?>
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
	$("#frmemotionalPaymentEdit").validate({            
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
  $( "#frmemotionalPaymentEdit" ).submit();
}
function AllTaxonomiesAction(action) {
if ($("#frmemotionalPaymentEdit input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#frmemotionalPaymentEdit").submit();  
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
@endif
</fieldset>

<script>
function conferma(e) {
	var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>");
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function() {
   $("#frmemotionalPayment").validate({            
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
</script>
@endsection