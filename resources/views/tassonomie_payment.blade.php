@extends('adminHome')
@section('page')
<h1>{{trans('messages.keyword_taxonomies_payments')}}</h1><hr>
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
		<input type="text" class="form-control" name="name" placeholder="{{trans('messages.keyword_name')}}"><br> 
	</div>

	<div class="col-md-4">
		<input type="text" class="form-control" name="description" placeholder="{{trans('messages.keyword_description')}}"><br> 
	</div>

	<div class="col-md-4">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" /><br>
	</div>

	<div class="col-md-12 text-right">
		<input type="submit" class="btn btn-primary" value="{{trans('messages.keyword_add')}}">
	</div>
	</div>
</form>

<h4>{{trans('messages.keyword_edit_emotional_payment_state')}}</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered text-right">
	@foreach($statepayments as $statepayment)    	
	<tr>
		<td>
			<form action="{{url('/admin/tassonomie/updatestatepayment')}}" method="post" id="frmemotionalPayment_{{$statepayment->id}}">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$statepayment->id}}">
					<table class="table sub-table">
		              <tr>
		                <td><input type="text" class="form-control" name="name" id="name" value="{{$statepayment->name}}"></td>
		                <td><input type="text" class="form-control" name="description" value="{{$statepayment->description}}"></td>
		                <td><input type="text" class="form-control color no-alpha" name="color" value="{{$statepayment->color}}"></td>
		                <td><input type="submit" class="btn btn-primary" value="Salva">
		                  <a  onclick="conferma(event);" type="submit" href="{{url('/admin/taxonomies/statepayment/delete/id' . '/' . $statepayment->id)}}" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a></td>
		              </tr>
				    </table>
			</form>
			<script type="text/javascript">
         $(document).ready(function() {
           $("#frmemotionalPayment_{{$statepayment->id}}").validate({            
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
		</td>
	</tr>       
	@endforeach
	</table>
	</div>
</form>
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