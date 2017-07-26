@extends('adminHome')

@section('page')
<h1> {{ trans('messages.keyword_tipoalert') }}  </h1><hr>
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

<?php /*<h4>{{ trans('messages.keyword_addtype') }} </h4>*/?>
<form action="{{url('/alert/add/tipo')}}" method="post" name="alerttipo" id="alerttipo">
    {{ csrf_field() }}
    <div class="row">
    	<div class="col-md-12">
    		<h4>{{ trans('messages.keyword_addtype') }}<label> <span class="required">(*)</span></label></h4>
    	</div>    
	<div class="col-md-4"> 		
		<div class="form-group">
		<input type="text" class="form-control" id="nome_tipo" name="nome_tipo" placeholder="{{ trans('messages.keyword_name') }} ">
		</div>
	</div>
	<div class="col-md-4">	
		<div class="form-group">		
		<input type="text" class="form-control" id="desc_tipo" name="desc_tipo" placeholder="{{ trans('messages.keyword_description') }} ">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">	
		<input class="form-control color no-alpha" value="#f37f0d" name="color" placeholder="{{ trans('messages.keyword_color') }}" id="color" />
		</div>
	</div>
	<div class="text-right">
		<input type="submit" class="btn btn-primary" value="{{ trans('messages.keyword_add') }}">
	</div>
	</div>
</form>
<h4>{{ trans('messages.keyword_modifytype') }} </h4>
<div class="row alltaxationeditparts">
  <div class="col-md-6">
  <div class="form-group m_select">
    <input id="chktasentitypeall" name="chktasentitypeall" value="1" type="checkbox">
     <label for="chktasentitypeall"> Select All </label>
  </div>
  </div>
  <div class="col-md-6 text-right">
    <input type="button" onclick="AllTaxonomiesAction('update')" class="btn btn-warning" value="{{trans('messages.keyword_save_selected')}}">
    <input type="button" onclick="AllTaxonomiesAction('delete')" class="btn btn-danger" value="{{trans('messages.keyword_delete_selected')}}">
  </div>
</div>
<div class="table-responsive alerttipo-blade-table">
	<form action="{{url('/admin/update/tipo')}}" method="post" id="modifyalerttipo" name="modifyalerttipo">
	<input type="hidden" id="actiontype" name="action" value="update">
	<table class="table table-striped table-bordered">		
	@foreach($alert_tipo as $type)		
		<tr>
		<td>		
		{{ csrf_field() }}
		<input type="hidden" name="id_tipo[]" value="{{$type->id_tipo}}">
		<table class="table sub-table">
			<tr><td>
                <input type="checkbox" class="form-control chktasentitype" name="chktasentitype[{{$type->id_tipo}}]" id="chktasentitype_{{$type->id_tipo}}" value="{{$type->id_tipo}}">
                <label for="chktasentitype_{{$type->id_tipo}}"></label></td>
				<td><input type="text" class="form-control" name="nome_tipo[{{$type->id_tipo}}]" id="nome_tipo" value="{{$type->nome_tipo}}" placeholder="{{ trans('messages.keyword_name') }}"></td>
				<td><input type="text" class="form-control" name="desc_tipo[{{$type->id_tipo}}]" value="{{$type->desc_tipo}}" placeholder="{{ trans('messages.keyword_description') }}"></td>
				<td><input type="text" class="form-control color no-alpha" name="color[{{$type->id_tipo}}]" value="{{$type->color}}" placeholder="{{ trans('messages.keyword_color') }}"></td>
				<?php /*<td class="text-right"><input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/delete/tipo' . '/' . $type->id_tipo)}}" class="btn btn-danger"> {{ trans('messages.keyword_clear') }}</a></td>*/?>

				<td><input type="button" onclick="SingleTaxonomiesAction('{{$type->id_tipo}}','update')" class="btn btn-warning" value="{{trans('messages.keyword_save')}}">
                  <a onclick="conferma(event);" type="button" href="javascript:SingleTaxonomiesAction('{{$type->id_tipo}}','delete')" class="btn btn-danger"> {{trans('messages.keyword_delete_label')}}</a></td>
			</tr>
		</table>	
		</td>
	</tr>	
	@endforeach	
	</table>
	</form>
	</div>	
</fieldset>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
</div>
<script>
	function conferma(e) {
	var confirmation = confirm("{{ trans('messages.keyword_sure') }}?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
$(document).ready(function() {
// validate add alert type form on keyup and submit
        $("#alerttipo").validate({            
            rules: {
                nome_tipo: {
                    required: true,
                }
            },
            messages: {
                nome_tipo: {
                    required: "{{trans('messages.keyword_please_enter_a_type_name')}}"
                }
            }
        });

        // validate edit alert type form on keyup and submit
        $("#modifyalerttipo").validate({            
            rules: {
                "nome_tipo[]": {
                    required: true,
                }
            },
            messages: {
                "nome_tipo[]": {
                    required: "{{trans('messages.keyword_please_enter_a_type_name')}}"
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
  $( "#modifyalerttipo" ).submit();
}
function AllTaxonomiesAction(action) {
if ($("#modifyalerttipo input:checkbox:checked").length > 0) {    
  if(action == 'delete'){
    var confirmation = confirm("<?php echo trans('messages.keyword_are_you_sure?');?>") ;
    if (!confirmation) {
      return false;
    }        
  }
  $("#actiontype").val(action);
  $( "#modifyalerttipo").submit();  
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
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection