@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_processing')}}</h1><hr>
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
/*$(window).load(function() {
  $(document).on(".cp-color-picker",'click',function(e){
    alert("sd");
  });
});
        /* $(".color1").on('change keyup paste mouseup', function() {
            alert("dsd");
        });*/
        // $('.color1').colorPicker(); // that's it */
        
         /*$('.color').colorPicker({
          onChange: function(hsb, hex, rgb){
            alert(hex);
            alert($(this).val());
            //$("#full").css("background-color", '#' + hex);
          },
          onSubmit: function(hsb, hex, rgb) {
           alert("cc");
          }
        });*/
       
         /*$('.color').on('input propertychange paste', function() {
          alert("cc");
        });
        $(".color").on('change keyup paste', function() {
           alert("cc sdfsd");
        });*/
</script>
@foreach($departments as $departments)
	<?php $lavorazioni = DB::table('lavorazioni')->where('departments_id', $departments->id)->get(); ?>
<fieldset class="top-up-wrap">
<form action="{{url('/admin/taxonomies/addprocessing')}}" method="post" id="frmemotionalProcessing">
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
    		<legend>{{$departments->nomedipartimento}}</legend>
    	</div>
    	<div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
    		<input class="form-control color no-alpha" onblur="departmentcolor('{{$departments->id}}')" id="departmentcolor_{{$departments->id}}" value="<?php echo isset($departments->color) ? $departments->color : '#f37f0d';?>" name="color" />
    	</div>
    	</div>
    </div>
    
<h4>{{trans('messages.keyword_add_type')}}</h4>
    {{ csrf_field() }}
    <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
    <div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" required="required" name="name" placeholder="{{trans('messages.keyword_name')}}">
		</div>
	</div>
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="form-group">
			<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}">
		</div>
	</div>	
	<div class="col-md-12 text-right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>
@if(count($lavorazioni) > 0)
<h4>{{trans('messages.keyword_edit_types')}}</h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select lblshow">
    <input id="chktasentitypeall_{{$departments->id}}" name="chktasentitypeall" onclick="checkall(this.value)" class="chktasentitypeall" value="{{$departments->id}}" type="checkbox">
     <label for="chktasentitypeall_{{$departments->id}}"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllTaxonomiesAction('{{$departments->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllTaxonomiesAction('{{$departments->id}}','delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
<form action="{{url('/admin/taxonomies/updateprocessing')}}" method="post" id="frmemotionalProcessingEdit_{{$departments->id}}">        
<input type="hidden" id="actiontype_{{$departments->id}}" name="action" value="update">
<div class="table-responsive">
		<table class="table table-striped table-bordered top-up text-right checkbox-tbl">
	@foreach($lavorazioni as $lavorazioni)		    	
		<tr>
		<td>
		{{ csrf_field() }}
    <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
		<input type="hidden" name="id[]" value="{{$lavorazioni->id}}">
		<table class="table sub-table">
              <tr>
              <td><input type="checkbox" class="form-control chktasentitype_{{$departments->id}} listofcheckbox" name="chktasentitype[{{$lavorazioni->id}}]" id="chktasentitype_{{$lavorazioni->id}}" value="{{$lavorazioni->id}}">
                <label for="chktasentitype_{{$lavorazioni->id}}"></label></td>
                <td width="20%" class="text-left"><label>{{trans('messages.keyword_processing_name')}}</label>
                  <input type="text" required="required" class="form-control" name="name[{{$lavorazioni->id}}]" id="name" value="<?php echo ($lavorazioni->language_key != "") ? trans('messages.'.$lavorazioni->language_key) : $lavorazioni->nome; ?>">
                                    <input type="hidden" name="langkey[{{$lavorazioni->id}}]" value="{{$lavorazioni->language_key}}"></td>
                <td class="text-left"><label>{{trans('messages.keyword_description')}}</label>
                  <input type="text" class="form-control" name="description[{{$lavorazioni->id}}]" value="{{$lavorazioni->description}}">
                  <input type="hidden" name="color[{{$lavorazioni->id}}]" value="{{$lavorazioni->color}}" />
                  <?php 
			// ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
			/*<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
			</div>*/?></td>
                <td width="15%"><div class="space20"></div><input type="button" onclick="SingleTaxonomiesAction('{{$departments->id}}','{{$lavorazioni->id}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$departments->id}}','{{$lavorazioni->id}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
                <?php /*<td width="15%">
                <div class="space20"></div>
                <input type="submit" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/deleteprocessing/id' . '/' . $lavorazioni->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>*/?>
              </tr>
            </table>			
	     </td>
	</tr>    
	@endforeach
	</table>
	</div>	
</form>
@endif
<script type="text/javascript">
   $(document).ready(function() {
     $("#frmemotionalProcessingEdit").validate({            
                rules: {
                    "name": {
                        required: true,
                    }
                },
                messages: {
                    "name": {
                        required: "{{trans('messages.keyword_please_enter_a_name')}}"
                    }
                }
            });
    });
   
   
   $(".chktasentitypeall").click(function (e) {
    var dpid = $(this).val();    
     $('.chktasentitype_'+dpid).not(this).prop('checked', this.checked);
     addremoveclass();
 });
  $(".listofcheckbox").click(function () {        
    addremoveclass();
 });
function SingleTaxonomiesAction(departid,id,action) {
  $("#chktasentitype_"+id).prop('checked', true);
  $("#actiontype_"+departid).val(action);
  $("#frmemotionalProcessingEdit_"+departid).submit();
}
function AllTaxonomiesAction(departid,action) {
if ($("#frmemotionalProcessingEdit_"+departid+" input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure_affected__section');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype_"+departid).val(action);
  $( "#frmemotionalProcessingEdit_"+departid).submit();  
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
	@endforeach
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
   $("#frmemotionalProcessing").validate({            
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



function departmentcolor(departmentid){
  var color = $("#departmentcolor_"+departmentid).val();  
   $.ajax({        
        url: "{{url('admin/taxonomies/updatedepartmentcolor/')}}",         
        type: 'post',
        data: { "_token": "{{ csrf_token() }}",departmentid: departmentid,color:color},
        success:function(data) {                               
              
        }
    });
}

</script>


@endsection